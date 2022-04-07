<?php

namespace Chess\Piece;

use Chess\Board;

trait PieceObserverBoardTrait
{
    public function updateBoard(Board $board): void
    {
        $this->board = $board;
    }
}
