<?php

namespace Chess\ML\Supervised\Classification;

use Chess\Board;
use Chess\HeuristicPicture;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\ML\Supervised\AbstractLinearCombinationPredictor;
use Chess\PGN\Symbol;
use Rubix\ML\PersistentModel;
use Rubix\ML\Datasets\Unlabeled;

class PermutationPredictor extends AbstractLinearCombinationPredictor
{
    public function __construct(Board $board, PersistentModel $estimator)
    {
        parent::__construct($board, $estimator);

        $this->permutations = (new RestrictedPermutationWithRepetition())
            ->get(
                [4, 28],
                count((new HeuristicPicture(''))->getDimensions()),
                100
            );
    }

    protected function evaluate(Board $clone): array
    {
        $balance = (new HeuristicPicture($clone->getMovetext(), $clone))->take()->getBalance();
        $dataset = new Unlabeled($balance);
        $end = end($balance);
        $label = (new PermutationLabeller($this->permutations))->label($end)[$this->board->getTurn()];

        return [
            'label' => $label,
            'prediction' => current($this->estimator->predict($dataset)),
            'linear_combination' => $this->combine($end, $label),
            'heuristic_eval' => (new HeuristicPicture($clone->getMovetext(), $clone))->evaluate(),
        ];
    }

    protected function sort(string $color): AbstractLinearCombinationPredictor
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

    protected function combine($end, $label)
    {
        $combination = 0;
        foreach ($end as $i => $val) {
            $combination += $this->permutations[$label][$i] * $val;
        }

        return $combination;
    }
}
