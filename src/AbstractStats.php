<?php

namespace PGNChess;

use PgnChess\Board;

/**
 * Abstract stats.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
abstract class AbstractStats
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
