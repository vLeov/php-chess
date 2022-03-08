<?php

namespace Chess\Piece;

use Chess\Board;

trait PieceObserverBoardTrait
{
    public function updateBoard(Board $board)
    {
        $this->board = $board;
    }
}
