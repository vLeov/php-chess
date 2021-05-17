<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\TacticsEvaluation;
use Chess\Evaluation\System;
use Chess\PGN\Symbol;

/**
 * Attack evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class AttackEvaluation extends AbstractEvaluation
{
    const NAME = 'attack';

    private $tacticsEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->tacticsEvald = (new TacticsEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function evaluate($feature = null): array
    {
        foreach ($this->tacticsEvald as $color => $squares) {
            foreach ($squares as $square) {
                $identity = $this->board->getPieceByPosition($square)->getIdentity();
                if ($identity !== Symbol::KING) {
                    $this->result[$color] += $this->system[System::SYSTEM_BERLINER][$identity];
                }
            }
        }

        return $this->result;
    }
}
