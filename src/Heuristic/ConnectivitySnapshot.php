<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractHeuristicSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;

/**
 * Connectivity snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class ConnectivitySnapshot extends AbstractHeuristicSnapshot
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
