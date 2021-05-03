<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristic\Picture\HeuristicPicture;
use Chess\PGN\Symbol;

class Sampler
{
    protected $board;

    protected $sample;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->sample = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }
    
    public function sample(): array
    {
        $heuristicPicture = (new HeuristicPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => end($heuristicPicture[Symbol::WHITE]),
            Symbol::BLACK => end($heuristicPicture[Symbol::BLACK]),
        ];

        return $this->sample;
    }
}
