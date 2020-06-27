<?php

namespace PGNChess;

use PgnChess\Board;
use PGNChess\Evaluation\Value\System;

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

    protected $system;

    protected $result;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->system = (new System())->get();
    }

    abstract public function evaluate(string $feature): array;
}
