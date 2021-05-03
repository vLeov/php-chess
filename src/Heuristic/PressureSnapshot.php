<?php

namespace Chess\Heuristic;

use Chess\AbstractSnapshot;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\Pressure as PressureEvaluation;

/**
 * Pressure snapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @see https://github.com/programarivm//blob/master/src/AbstractSnapshot.php
 */
class PressureSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $pressEvald = (new PressureEvaluation($this->board))->evaluate();
            $this->snapshot[] = [
                Symbol::WHITE => count($pressEvald[Symbol::WHITE]),
                Symbol::BLACK => count($pressEvald[Symbol::BLACK]),
            ];
        }
        $this->normalize();

        return $this->snapshot;
    }
}
