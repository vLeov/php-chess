<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\System;

/**
 * Abstract evaluation.
 *
 * @author Jordi Bassagañas
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

    abstract public function evaluate($feature = null): array;
}
