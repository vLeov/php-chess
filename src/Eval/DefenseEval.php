<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

/**
 * Defense evaluation.
 *
 * Squares containing the pieces being defended.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class DefenseEval extends AbstractEval
{
    const NAME = 'Defense';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
            $this->result[$piece->getColor()] = [
                ...$this->result[$piece->getColor()],
                ...$piece->defendedSqs()
            ];
            $this->board->next();
        }

        sort($this->result[Color::W]);
        sort($this->result[Color::B]);
    }
}
