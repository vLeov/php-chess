<?php

namespace Chess\Eval;

use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;

class OverloadingEval extends AbstractEval implements ExplainEvalInterface
{
    use ExplainEvalTrait;

    const NAME = 'Overloading';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        $this->range = [1, 4];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a slight overloading advantage",
            "has a moderate overloading advantage",
            "has a total overloading advantage",
        ];

        foreach ($this->board->pieces() as $piece) {
            if (count($piece->defendedSqs()) > 1) {
                $this->result[$piece->color][] = $piece->sq;
            }
        }

        $this->explain([
            Color::W => count($this->result[Color::W]),
            Color::B => count($this->result[Color::B]),
        ]);
    }
}
