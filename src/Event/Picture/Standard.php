<?php

namespace PGNChess\Event\Picture;

use PGNChess\AbstractPicture;
use PGNChess\Event\Check as CheckEvent;
use PGNChess\Event\PieceCapture as PieceCaptureEvent;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class Standard extends AbstractPicture
{
    const N_DIMENSIONS = 2;

    /**
     * Takes a picture of standard events.
     *
     * @return array
     */
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));

            $this->picture[Symbol::WHITE][] = [
                (new PieceCaptureEvent($this->board))->capture(Symbol::WHITE),
                (new CheckEvent($this->board))->capture(Symbol::WHITE),
            ];

            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }

            $this->picture[Symbol::BLACK][] = [
                (new PieceCaptureEvent($this->board))->capture(Symbol::BLACK),
                (new CheckEvent($this->board))->capture(Symbol::BLACK),
            ];
        }

        return $this->picture;
    }
}
