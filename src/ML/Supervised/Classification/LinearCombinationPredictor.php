<?php

namespace Chess\ML\Supervised\Classification;

use Chess\Board;
use Chess\HeuristicPictureByFenString;
use Chess\FEN\BoardToString;
use Chess\ML\Supervised\AbstractLinearCombinationPredictor;
use Chess\ML\Supervised\Classification\LinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Rubix\ML\Datasets\Unlabeled;

/**
 * LinearCombinationPredictor
 *
 * Predicts the best possible move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationPredictor extends AbstractLinearCombinationPredictor
{
    /**
     * Returns the best possible move.
     *
     * @return string
     */
    public function predict(): string
    {
        $color = $this->board->getTurn();
        foreach ($this->board->getPossibleMoves() as $possibleMove) {
            $clone = unserialize(serialize($this->board));
            $clone->play($color, $possibleMove);
            $this->result[] = [ $possibleMove => $this->evaluate($clone) ];
        }
        $found = $this->sort($color)->find();

        return $found;
    }

    /**
     * Evaluates a chess position.
     *
     * @return array
     */
    protected function evaluate(Board $clone): array
    {
        $fen = (new BoardToString($clone))->create();
        $balance = (new HeuristicPictureByFenString($fen))->take()->getBalance();
        $dataset = new Unlabeled([$balance]);
        $label = (new LinearCombinationLabeller($this->permutations))
            ->label($balance)[$this->board->getTurn()];
        $prediction = current($this->estimator->predict($dataset));

        return [
            'label' => $label,
            'prediction' => $prediction,
            'linear_combination' => $this->combine($balance, $label),
            'heuristic_eval' => (new HeuristicPictureByFenString($fen))->evaluate(),
        ];
    }

    /**
     * Sorts all possible moves by their heuristic evaluation value along with their linear combination value.
     *
     * @return \Chess\ML\Supervised\Classification\LinearCombinationPredictor
     */

    protected function sort(string $color): LinearCombinationPredictor
    {
        usort($this->result, function ($a, $b) use ($color) {
            if ($color === Symbol::WHITE) {
                $current =
                    (current($b)['heuristic_eval']['b'] - current($b)['heuristic_eval']['w'] <=>
                        current($a)['heuristic_eval']['b'] - current($a)['heuristic_eval']['w']) * 10 +
                    (current($b)['linear_combination'] <=> current($a)['linear_combination']);
            } else {
                $current =
                    (current($a)['heuristic_eval']['w'] - current($a)['heuristic_eval']['b'] <=>
                        current($b)['heuristic_eval']['w'] - current($b)['heuristic_eval']['b']) * 10 +
                    (current($a)['linear_combination'] <=> current($b)['linear_combination']);
            }
            return $current;
        });

        return $this;
    }

    /**
     * Finds the move to be made by matching the current label with the predicted label.
     *
     * @return string
     */
    protected function find(): string
    {
        foreach ($this->result as $key => $val) {
            $current = current($val);
            if ($current['label'] === $current['prediction']) {
                return key($this->result[$key]);
            }
        }

        return key($this->result[0]);
    }
}
