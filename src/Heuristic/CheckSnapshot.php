<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractHeuristicSnapshot;
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
class CheckSnapshot extends AbstractHeuristicSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $this->snapshot[] = [
                Symbol::WHITE => (int) ($this->board->getTurn() === Symbol::WHITE && $this->board->isCheck()),
                Symbol::BLACK => (int) ($this->board->getTurn() === Symbol::BLACK && $this->board->isCheck()),
            ];
        }

        return $this->snapshot;
    }
}
