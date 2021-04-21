<?php

namespace Chess\Event\Picture;

use Chess\AbstractPicture;
use Chess\Event\Check as CheckEvent;
use Chess\Event\PieceCapture as PieceCaptureEvent;
use Chess\Event\MajorPieceThreatenedByPawn as MajorPieceThreatenedByPawnEvent;
use Chess\Event\MinorPieceThreatenedByPawn as MinorPieceThreatenedByPawnEvent;
use Chess\Event\MajorPieceWithinPawnScope as MajorPieceWithinPawnScopeEvent;
use Chess\Event\MinorPieceWithinPawnScope as MinorPieceWithinPawnScopeEvent;
use Chess\Event\Promotion as PromotionEvent;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

class Basic extends AbstractPicture
{
    const N_DIMENSIONS = 7;

    /**
     * Takes a picture of events.
     *
     * @return array
     */
    public function take(): array
    {
        if ($this->moves) {
            foreach ($this->moves as $move) {
                $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
                $this->picture[Symbol::WHITE][] = [
                    (new CheckEvent($this->board))->capture(Symbol::WHITE),
                    (new PieceCaptureEvent($this->board))->capture(Symbol::WHITE),
                    (new MajorPieceThreatenedByPawnEvent($this->board))->capture(Symbol::WHITE),
                    (new MajorPieceWithinPawnScopeEvent($this->board))->capture(Symbol::BLACK),
                    (new MinorPieceThreatenedByPawnEvent($this->board))->capture(Symbol::WHITE),
                    (new MinorPieceWithinPawnScopeEvent($this->board))->capture(Symbol::BLACK),
                    (new PromotionEvent($this->board))->capture(Symbol::WHITE),
                ];
                if (isset($move[1])) {
                    $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
                }
                $this->picture[Symbol::BLACK][] = [
                    (new CheckEvent($this->board))->capture(Symbol::BLACK),
                    (new PieceCaptureEvent($this->board))->capture(Symbol::BLACK),
                    (new MajorPieceThreatenedByPawnEvent($this->board))->capture(Symbol::BLACK),
                    (new MajorPieceWithinPawnScopeEvent($this->board))->capture(Symbol::WHITE),
                    (new MinorPieceThreatenedByPawnEvent($this->board))->capture(Symbol::BLACK),
                    (new MinorPieceWithinPawnScopeEvent($this->board))->capture(Symbol::WHITE),
                    (new PromotionEvent($this->board))->capture(Symbol::BLACK),
                ];
            }
        } else {
            $this->picture[Symbol::WHITE][] = $this->picture[Symbol::BLACK][] = array_fill(0, static::N_DIMENSIONS, 0);
        }

        return $this->picture;
    }
}
