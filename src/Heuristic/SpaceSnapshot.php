<?php

namespace Chess\Heuristic;

use Chess\AbstractSnapshot;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\Space as SpaceEvaluation;

/**
 * Space snapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @see https://github.com/programarivm//blob/master/src/AbstractSnapshot.php
 */
class SpaceSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $spEvald = (new SpaceEvaluation($this->board))->evaluate();
            $this->snapshot[] = [
                Symbol::WHITE => count($spEvald[Symbol::WHITE]),
                Symbol::BLACK => count($spEvald[Symbol::BLACK]),
            ];
        }
        $this->normalize();

        return $this->snapshot;
    }
}
