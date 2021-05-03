<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\Pressure as PressureEvaluation;
use Chess\Evaluation\Value\System as System;
use Chess\PGN\Symbol;

/**
 * Attack evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Attack extends AbstractEvaluation
{
    const NAME = 'attack';

    private $pressEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->pressEvald = (new PressureEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function evaluate($feature = null): array
    {
        foreach ($this->pressEvald[Symbol::WHITE] as $sq) {
            $identity = $this->board->getPieceByPosition($sq)->getIdentity();
            if ($identity !== Symbol::KING) {
                $this->result[Symbol::WHITE] += $this->system[System::SYSTEM_BERLINER][$identity];
            }
        }

        foreach ($this->pressEvald[Symbol::BLACK] as $sq) {
            $identity = $this->board->getPieceByPosition($sq)->getIdentity();
            if ($identity !== Symbol::KING) {
                $this->result[Symbol::BLACK] += $this->system[System::SYSTEM_BERLINER][$identity];
            }
        }

        return $this->result;
    }
}
