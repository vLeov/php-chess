<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractHeuristicSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Value\System;

/**
 * King safety snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class KingSafetySnapshot extends AbstractHeuristicSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $kSafetyEvald = (new KingSafetyEvaluation($this->board))->evaluate();
            $this->snapshot[] = [
                Symbol::WHITE => $kSafetyEvald[Symbol::WHITE],
                Symbol::BLACK => $kSafetyEvald[Symbol::BLACK],
            ];
        }

        return $this->snapshot;
    }
}
