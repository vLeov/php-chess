<?php

namespace PGNChess;

use PGNChess\Board;

abstract class AbstractOpening
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
