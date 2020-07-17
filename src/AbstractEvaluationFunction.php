<?php

namespace PGNChess;

use PgnChess\Board;

/**
 * Abstract evaluation function.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
abstract class AbstractEvaluationFunction
{
    protected $board;

    protected $result;

    protected $weights;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = 0;
    }

    abstract public function calculate(): float;
}
