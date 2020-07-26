<?php

namespace PGNChess\ML\Supervised\Regression\Labeller;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Check as CheckEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Evaluation\Value\System;

/**
 * Primes labeller.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class PrimesLabeller
{
    const WEIGHT = [
      AttackEvaluation::NAME => 2,
      ConnectivityEvaluation::NAME => 3,
      CenterEvaluation::NAME => 5,
      KingSafetyEvaluation::NAME => 7,
      MaterialEvaluation::NAME => 11,
      CheckEvaluation::NAME => 13,
    ];

    private $board;

    private $label;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function calc(): array
    {
        $attEvald = (new AttackEvaluation($this->board))->evaluate();
        $connEvald = (new ConnectivityEvaluation($this->board))->evaluate();
        $ctrEvald = (new CenterEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
        $kSafetyEvald = (new KingSafetyEvaluation($this->board))->evaluate();
        $mtlEvald = (new MaterialEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
        $checkEvald = (new CheckEvaluation($this->board))->evaluate();

        $attEvald = [
            Symbol::WHITE => count($attEvald[Symbol::WHITE]),
            Symbol::BLACK => count($attEvald[Symbol::BLACK]),
        ];

        $eval = [
          AttackEvaluation::NAME => $attEvald,
          ConnectivityEvaluation::NAME => $connEvald,
          CenterEvaluation::NAME => $ctrEvald,
          KingSafetyEvaluation::NAME => $kSafetyEvald,
          MaterialEvaluation::NAME => $mtlEvald,
          CheckEvaluation::NAME => $checkEvald,
        ];

        foreach ($eval as $key => $val) {
            $this->label[Symbol::WHITE] += self::WEIGHT[$key] * $val[Symbol::WHITE];
            $this->label[Symbol::BLACK] += self::WEIGHT[$key] * $val[Symbol::BLACK];
        }

        return $this->label;
    }
}
