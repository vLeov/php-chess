<?php

namespace Chess\Event\Picture;

use Chess\AbstractPicture;
use Chess\Event\Check as CheckEvent;
use Chess\Event\PieceCapture as PieceCaptureEvent;
use Chess\Event\MajorPieceThreatenedByPawn as MajorPieceThreatenedByPawnEvent;
use Chess\Event\MinorPieceThreatenedByPawn as MinorPieceThreatenedByPawnEvent;
use Chess\Event\Promotion as PromotionEvent;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

class Basic extends AbstractPicture
{
    protected $dimensions = [
        CheckEvent::class,
        PieceCaptureEvent::class,
        MajorPieceThreatenedByPawnEvent::class,
        MinorPieceThreatenedByPawnEvent::class,
        PromotionEvent::class,
    ];

    /**
     * Takes a picture of events.
     *
     * @return array
     */
    public function take(): array
    {
        if ($this->moves) {
            foreach ($this->moves as $i => $move) {
                $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
                foreach ($this->dimensions as $d) {
                    $this->picture[Symbol::WHITE][$i][] = (new $d($this->board))->capture(Symbol::WHITE);
                }
                if (isset($move[1])) {
                    $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
                }
                foreach ($this->dimensions as $d) {
                    $this->picture[Symbol::BLACK][$i][] = (new $d($this->board))->capture(Symbol::BLACK);
                }
            }
        } else {
            $this->picture[Symbol::WHITE][] = $this->picture[Symbol::BLACK][] = array_fill(0, count($this->dimensions), 0);
        }

        return $this->picture;
    }
}
