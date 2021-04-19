<?php

namespace Chess\Heuristic;

use Chess\AbstractSnapshot;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Event\PieceCapture as PieceCaptureEvent;

/**
 * Piece capture snapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @see https://github.com/programarivm//blob/master/src/AbstractSnapshot.php
 */
class PieceCaptureSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            $w = (new PieceCaptureEvent($this->board))->capture(Symbol::WHITE);
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
                $b = (new PieceCaptureEvent($this->board))->capture(Symbol::BLACK);
            } else {
                $b = 0;
            }
            $this->snapshot[] = [
                Symbol::WHITE => $w,
                Symbol::BLACK => $b,
            ];
        }

        return $this->snapshot;
    }
}
