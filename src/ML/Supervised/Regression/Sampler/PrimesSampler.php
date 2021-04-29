<?php

namespace Chess\ML\Supervised\Regression\Sampler;

use Chess\Board;
use Chess\Heuristic\Picture\Weighted as WeightedHeuristicPicture;
use Chess\PGN\Symbol;

class PrimesSampler extends AbstractSampler
{
    public function sample(): array
    {
        $heuristicPicture = (new WeightedHeuristicPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => end($heuristicPicture[Symbol::WHITE]),
            Symbol::BLACK => end($heuristicPicture[Symbol::BLACK]),
        ];

        return $this->sample;
    }
}
