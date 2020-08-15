<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Capture as CaptureEvaluation;

/**
 * Capture snapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @see https://github.com/programarivm/pgn-chess/blob/master/src/AbstractSnapshot.php
 */
class CaptureSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $captureEvald = (new CaptureEvaluation($this->board))->evaluate();
            $this->snapshot[] = [
                Symbol::WHITE => $captureEvald[Symbol::WHITE],
                Symbol::BLACK => $captureEvald[Symbol::BLACK],
            ];
        }

        return $this->snapshot;
    }
}
