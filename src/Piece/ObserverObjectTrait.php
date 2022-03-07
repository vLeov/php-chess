<?php

namespace Chess\Piece;

use Chess\Board;

trait ObserverObjectTrait
{
    public function updateObject(Board $subject)
    {
        $this->board = $subject;
    }
}
