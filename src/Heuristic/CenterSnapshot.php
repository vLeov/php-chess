<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractHeuristicSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Value\System;

/**
 * Center snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class CenterSnapshot extends AbstractHeuristicSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $ctrEvald = (new CenterEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
            $this->snapshot[] = [
                Symbol::WHITE => $ctrEvald[Symbol::WHITE],
                Symbol::BLACK => $ctrEvald[Symbol::BLACK],
            ];
        }

        return $this->snapshot;
    }
}
