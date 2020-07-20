<?php

namespace PGNChess\ML\Supervised\Regression\Labeller;

use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Check as CheckEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;

/**
 * Primes.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Primes
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
          CheckEvaluation::NAME => 13,
        ];
    }

    public function calc(): float
    {
        // TODO

        return $label;
    }
}
