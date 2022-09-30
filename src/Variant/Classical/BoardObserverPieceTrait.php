<?php

namespace Chess\Variant\Classical;

use Chess\Piece\AbstractPiece;

trait BoardObserverPieceTrait
{
    public function notifyPieces(): void
    {
        foreach ($this->observers as $piece) {
            $piece->setBoard($this);
        }
    }

    public function attachPieces()
    {
        $this->rewind();
        while ($this->valid()) {
            $this->observers[] = $this->current();
            $this->next();
        }

        return $this;
    }

    public function detachPieces()
    {
        unset($this->observers);

        return $this;
    }
}
