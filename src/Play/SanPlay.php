<?php

namespace Chess\Play;

use Chess\Exception\PlayException;
use Chess\Movetext\SanMovetext;
use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\Move;

class SanPlay extends AbstractPlay
{
    protected SanMovetext $sanMovetext;

    public function __construct(string $movetext, AbstractBoard $board = null)
    {
        if ($board) {
            $this->initialBoard = $board;
            $this->board = $board->clone();
        } else {
            $this->initialBoard = new Board();
            $this->board = new Board();
        }
        $this->fen = [$this->board->toFen()];
        $this->sanMovetext = new SanMovetext($this->board->move, $movetext);
        $this->sanMovetext->validate();
    }

    public function getSanMovetext(): SanMovetext
    {
        return $this->sanMovetext;
    }

    public function validate(): SanPlay
    {
        foreach ($this->sanMovetext->getMoves() as $key => $val) {
            if ($val !== Move::ELLIPSIS) {
                if (!$this->board->play($this->board->turn, $val)) {
                    throw new PlayException();
                }
                $this->fen[] = $this->board->toFen();
            }
        }

        return $this;
    }
}
