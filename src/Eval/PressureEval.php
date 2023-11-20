<?php

namespace Chess\Eval;

use Chess\Eval\SqCount;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * Pressure evaluation.
 *
 * Squares being threatened at the present moment.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class PressureEval extends AbstractEval
{
    const NAME = 'Pressure';

    /**
     * Count squares.
     *
     * @var object
     */
    private object $sqCount;

    /**
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sqCount = (new SqCount($board))->count();

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];
    }

    /**
     * Returns the squares being threatened at the present moment.
     *
     * @return array
     */
    public function eval(): array
    {
        foreach ($pieces = $this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::K) {
                $this->result[$piece->getColor()] = [
                    ...$this->result[$piece->getColor()],
                    ...array_intersect(
                        (array) $piece->getMobility(),
                        $this->sqCount->used->{$piece->oppColor()}
                    )
                ];
            } elseif ($piece->getId() === Piece::P) {
                $this->result[$piece->getColor()] = [
                    ...$this->result[$piece->getColor()],
                    ...array_intersect(
                        $piece->getCaptureSqs(),
                        $this->sqCount->used->{$piece->oppColor()}
                    )
                ];
            } else {
                $this->result[$piece->getColor()] = [
                    ...$this->result[$piece->getColor()],
                    ...array_intersect(
                        $piece->sqs(),
                        $this->sqCount->used->{$piece->oppColor()}
                    )
                ];
            }
        }

        return $this->result;
    }
}
