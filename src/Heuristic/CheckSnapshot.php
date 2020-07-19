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
            $item = [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ];
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            $this->board->isCheck() ? $item[Symbol::WHITE] = 1 : $item[Symbol::WHITE] = 0;
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
                $this->board->isCheck() ? $item[Symbol::BLACK] = 1 : $item[Symbol::BLACK] = 0;
            }
            $this->snapshot[] = $item;
        }

        return $this->snapshot;
    }
}
