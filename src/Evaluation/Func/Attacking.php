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
 * Attacking.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Attacking extends AbstractEvaluationFunction
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->weights = [
          AttackEvaluation::NAME => 5,
          ConnectivityEvaluation::NAME => 4,
          CenterEvaluation::NAME => 3,
          KingSafetyEvaluation::NAME => 2,
          MaterialEvaluation::NAME => 1,
        ];
    }

    public function calculate(): float
    {
        // TODO 

        return $this->result;
    }
}
