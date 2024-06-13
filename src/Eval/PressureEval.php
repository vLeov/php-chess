<?php

namespace Chess\Eval;

use Chess\Eval\SqCount;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

class PressureEval extends AbstractEval implements ExplainEvalInterface
{
    use ExplainEvalTrait;

    const NAME = 'Pressure';

    private object $sqCount;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->sqCount = (new SqCount($board))->count();

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        $this->range = [1, 4];

        $this->subject = [
            'The white player',
            'The black player',
        ];

        $this->observation = [
            "is pressuring a little bit more squares than its opponent",
            "is significantly pressuring more squares than its opponent",
            "is utterly pressuring more squares than its opponent",
        ];

        foreach ($pieces = $this->board->pieces() as $piece) {
            if ($piece->id === Piece::K) {
                $this->result[$piece->color] = [
                    ...$this->result[$piece->color],
                    ...array_intersect(
                        $piece->mobility,
                        $this->sqCount->used->{$piece->oppColor()}
                    )
                ];
            } elseif ($piece->id === Piece::P) {
                $this->result[$piece->color] = [
                    ...$this->result[$piece->color],
                    ...array_intersect(
                        $piece->captureSqs,
                        $this->sqCount->used->{$piece->oppColor()}
                    )
                ];
            } else {
                $this->result[$piece->color] = [
                    ...$this->result[$piece->color],
                    ...array_intersect(
                        $piece->legalSqs(),
                        $this->sqCount->used->{$piece->oppColor()}
                    )
                ];
            }
        }

        $this->explain([
            Color::W => count($this->result[Color::W]),
            Color::B => count($this->result[Color::B]),
        ]);
    }
}
