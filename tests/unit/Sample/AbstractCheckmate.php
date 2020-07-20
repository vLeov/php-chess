<?php

namespace PGNChess\Tests\Unit\Sample;

use PGNChess\Board;

abstract class AbstractCheckmate
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
