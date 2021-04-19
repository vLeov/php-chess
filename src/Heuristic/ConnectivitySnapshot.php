<?php

namespace Chess\Heuristic;

use Chess\AbstractSnapshot;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\Connectivity as ConnectivityEvaluation;

/**
 * Connectivity snapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @see https://github.com/programarivm//blob/master/src/AbstractSnapshot.php
 */
class ConnectivitySnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $connEvald = (new ConnectivityEvaluation($this->board))->evaluate();
            $this->snapshot[] = [
                Symbol::WHITE => $connEvald[Symbol::WHITE],
                Symbol::BLACK => $connEvald[Symbol::BLACK],
            ];
        }
        $this->normalize();

        return $this->snapshot;
    }
}
