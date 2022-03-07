<?php

namespace Chess;

use Chess\Piece\Piece;

trait ObserverSubjectTrait
{
    public function attachObserver(Piece $observer): void
    {
        $key = spl_object_hash($observer);
        $this->observers[$key] = $observer;
    }

    public function notifyObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->updateObject($this);
        }
    }

    public function attachObservers()
    {
        $this->rewind();
        while ($this->valid()) {
            $this->attachObserver($this->current());
            $this->next();
        }

        return $this;
    }

    public function detachObservers()
    {
        unset($this->observers);

        return $this;
    }
}
