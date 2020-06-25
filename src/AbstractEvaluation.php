<?php

namespace PGNChess;

use PgnChess\Board;

/**
 * Abstract evaluation.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
abstract class AbstractEvaluation
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
