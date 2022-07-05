<?php

namespace Chess\Piece;

use Chess\Board;

trait PieceObserverBoardTrait
{
    public function setBoard(Board $board): void
    {
        $this->board = $board;
    }
}
