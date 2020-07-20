<?php

namespace PGNChess\Tests\Unit\Sample;

use PGNChess\Board;

abstract class AbstractOpening
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
