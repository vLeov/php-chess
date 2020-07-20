<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Check as CheckEvaluation;

/**
 * Check snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class CheckSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $checkEvald = (new CheckEvaluation($this->board))->evaluate();
            $this->snapshot[] = [
                Symbol::WHITE => $checkEvald[Symbol::WHITE],
                Symbol::BLACK => $checkEvald[Symbol::BLACK],
            ];
        }

        return $this->snapshot;
    }
}
