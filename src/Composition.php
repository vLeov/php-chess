<?php

namespace Chess;

use Chess\Board;

class Composition
{
    protected $board;

    public function __construct(Board $board)
    {
        $this->board = unserialize(serialize($board));
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function deletePieceByPosition(string $sq): Composition
    {
        $piece = $this->board->getPieceBySq($sq);
        $this->board->detach($piece);
        $this->board->refresh();

        return $this;
    }

    public function setTurn(string $color): Composition
    {
        $this->board->setTurn($color);

        return $this;
    }
}
