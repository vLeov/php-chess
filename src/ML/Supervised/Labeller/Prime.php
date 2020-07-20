<?php

namespace PGNChess\Evaluation\Func;

use PGNChess\AbstractEvaluationFunction;
use PgnChess\Board;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Evaluation\Value\System;
use PGNChess\PGN\Symbol;

/**
 * Prime.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Prime extends AbstractEvaluationFunction
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->weights = [
          AttackEvaluation::NAME => 2,
          ConnectivityEvaluation::NAME => 3,
          CenterEvaluation::NAME => 5,
          KingSafetyEvaluation::NAME => 7,
          MaterialEvaluation::NAME => 11,
        ];
    }

    public function calc(): float
    {
        // TODO

        return $this->result;
    }
}
