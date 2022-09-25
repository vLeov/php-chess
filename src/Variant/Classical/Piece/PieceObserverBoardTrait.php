<?php

namespace Chess\Variant\Classical\Piece;

use Chess\Variant\Classical\Board;

trait PieceObserverBoardTrait
{
    public function setBoard(Board $board): void
    {
        $this->board = $board;
    }
}
