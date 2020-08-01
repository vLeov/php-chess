<?php

namespace PGNChess\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Check as CheckEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Evaluation\Value\System;

class Sampler
{
    private $board;

    private $sample;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->sample = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function sample(): array
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

        $this->sample = [
            Symbol::WHITE => [
                $attEvald[Symbol::WHITE],
                $connEvald[Symbol::WHITE],
                $ctrEvald[Symbol::WHITE],
                $kSafetyEvald[Symbol::WHITE],
                $mtlEvald[Symbol::WHITE],
                $checkEvald[Symbol::WHITE],
            ],
            Symbol::BLACK => [
                $attEvald[Symbol::BLACK],
                $connEvald[Symbol::BLACK],
                $ctrEvald[Symbol::BLACK],
                $kSafetyEvald[Symbol::BLACK],
                $mtlEvald[Symbol::BLACK],
                $checkEvald[Symbol::BLACK],
            ],
        ];

        return $this->sample;
    }
}
