<?php

namespace Chess\ML\Supervised\Regression\Sampler;

use Chess\Board;
use Chess\Event\Picture\Basic as BasicEventPicture;
use Chess\Heuristic\Picture\Weighted as WeightedHeuristicPicture;
use Chess\PGN\Symbol;

class PrimesSampler extends AbstractSampler
{
    public function sample(): array
    {
        $eventPicture = (new BasicEventPicture($this->board->getMovetext()))->take();
        $heuristicPicture = (new WeightedHeuristicPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => array_merge(
                end($eventPicture[Symbol::WHITE]),
                end($heuristicPicture[Symbol::WHITE])
            ),
            Symbol::BLACK => array_merge(
                end($eventPicture[Symbol::BLACK]),
                end($heuristicPicture[Symbol::BLACK])
            ),
        ];

        return $this->sample;
    }
}
