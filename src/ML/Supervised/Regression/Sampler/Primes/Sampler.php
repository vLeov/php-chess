<?php

namespace PGNChess\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Evaluation\Value\System;
use PGNChess\Event\Check as CheckEvent;
use PGNChess\Event\PieceCapture as PieceCaptureEvent;

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

        $attEvald = [
            Symbol::WHITE => count($attEvald[Symbol::WHITE]),
            Symbol::BLACK => count($attEvald[Symbol::BLACK]),
        ];

        $attdEvald = [
            Symbol::WHITE => $attEvald[Symbol::BLACK],
            Symbol::BLACK => $attEvald[Symbol::WHITE],
        ];

        $this->sample = [
            Symbol::WHITE => [
                $attEvald[Symbol::WHITE],
                $connEvald[Symbol::WHITE],
                $ctrEvald[Symbol::WHITE],
                $attdEvald[Symbol::WHITE],
                $kSafetyEvald[Symbol::WHITE],
                $mtlEvald[Symbol::WHITE],
                (new PieceCaptureEvent($this->board))->capture(Symbol::WHITE),
                (new CheckEvent($this->board))->capture(Symbol::WHITE),
            ],
            Symbol::BLACK => [
                $attEvald[Symbol::BLACK],
                $connEvald[Symbol::BLACK],
                $ctrEvald[Symbol::BLACK],
                $attdEvald[Symbol::BLACK],
                $kSafetyEvald[Symbol::BLACK],
                $mtlEvald[Symbol::BLACK],
                (new PieceCaptureEvent($this->board))->capture(Symbol::BLACK),
                (new CheckEvent($this->board))->capture(Symbol::BLACK),
            ],
        ];

        return $this->sample;
    }
}
