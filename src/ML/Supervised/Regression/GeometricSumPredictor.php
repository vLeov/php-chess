<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\HeuristicsByFenString;
use Chess\PGN\AN\Color;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\PersistentModel;

class GeometricSumPredictor
{
    protected Board $board;

    protected PersistentModel $estimator;

    protected array $result = [];

    public function __construct(Board $board, PersistentModel $estimator)
    {
        $this->board = $board;
        $this->estimator = $estimator;
    }

    protected function eval(Board $clone, $prediction): array
    {
        $balance = (new HeuristicsByFenString($clone->toFen()))->getResizedBalance(0, 1);
        $label = (new GeometricSumLabeller())->label($balance);

        return [
            'label' => $label,
            'prediction' => $prediction,
            'diff' => abs($label - $prediction)
        ];
    }

    protected function sort(string $color): GeometricSumPredictor
    {
        usort($this->result, function ($a, $b) use ($color) {
            if ($color === Color::W) {
                $current = current($b)['diff'] <=> current($a)['diff'];
            } else {
                $current = current($a)['diff'] <=> current($b)['diff'];
            }
            return $current;
        });

        return $this;
    }

    public function predict(): string
    {
        $balance = (new HeuristicsByFenString($this->board->toFen()))->getResizedBalance(0, 1);
        $dataset = new Unlabeled([$balance]);
        $prediction = current($this->estimator->predict($dataset));
        $color = $this->board->getTurn();
        foreach ($this->board->legalMoves() as $legalMove) {
            $clone = unserialize(serialize($this->board));
            $clone->play($color, $legalMove);
            $this->result[] = [
                $legalMove => $this->eval($clone, $prediction)
            ];
        }
        $this->sort($color);
        $current = current(array_keys($this->result[0]));

        return $current;
    }
}
