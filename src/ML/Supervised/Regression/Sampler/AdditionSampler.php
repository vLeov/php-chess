<?php

namespace Chess\ML\Supervised\Regression\Sampler;

use Chess\Board;
use Chess\Heuristic\Picture\Addition as AdditionHeuristicPicture;
use Chess\PGN\Symbol;

class AdditionSampler extends AbstractSampler
{
    public function sample(): array
    {
        $heuristicPicture = (new AdditionHeuristicPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => end($heuristicPicture[Symbol::WHITE]),
            Symbol::BLACK => end($heuristicPicture[Symbol::BLACK]),
        ];

        return $this->sample;
    }
}
