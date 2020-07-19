<?php

namespace PGNChess;

use PGNChess\Board;

abstract class AbstractCheckmate
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
