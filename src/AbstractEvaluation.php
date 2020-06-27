<?php

namespace PGNChess;

use PgnChess\Board;
use PGNChess\PGN\Symbol;

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

    abstract public function evaluate(string $name): array;
}
