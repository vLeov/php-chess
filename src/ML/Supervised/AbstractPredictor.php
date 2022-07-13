<?php

namespace Chess\ML\Supervised;

use Chess\Board;
use Chess\PGN\AN\Color;
use Rubix\ML\PersistentModel;

abstract class AbstractPredictor
{
    protected Board $board;

    protected PersistentModel $estimator;

    protected array $result = [];

    abstract protected function eval(Board $clone): array;

    public function __construct(Board $board, PersistentModel $estimator)
    {
        $this->board = $board;
        $this->estimator = $estimator;
    }

    protected function sort(string $color): AbstractPredictor
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
        $color = $this->board->getTurn();
        foreach ($this->board->legalMoves() as $possibleMove) {
            $clone = unserialize(serialize($this->board));
            $clone->play($color, $possibleMove);
            $this->result[] = [ $possibleMove => $this->eval($clone) ];
        }

        $this->sort($color);

        $prediction = current(array_keys($this->result[0]));

        return $prediction;
    }
}
