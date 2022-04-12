<?php

namespace Chess;

use Chess\Piece\AbstractPiece;

trait BoardObserverPieceTrait
{
    public function attachPiece(AbstractPiece $piece): void
    {
        $key = spl_object_hash($piece);
        $this->observers[$key] = $piece;
    }

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
            $this->attachPiece($this->current());
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
