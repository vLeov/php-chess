<?php

namespace Chess;

use Chess\Piece\AbstractPiece;

trait BoardObserverPieceTrait
{
    public function notifyPieces(): void
    {
        foreach ($this->observers as $piece) {
            $piece->updateBoard($this);
        }
    }

    public function attachPieces()
    {
        $this->rewind();
        while ($this->valid()) {
            $key = spl_object_hash($this->current());
            $this->observers[$key] = $this->current();
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
