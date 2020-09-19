<?php

namespace PGNChess\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\Heuristic\Picture\Standard as StandardHeuristicPicture;
use PGNChess\PGN\Symbol;

class Sampler
{
    private $board;

    private $sample;

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
        $heuristicPicture = (new StandardHeuristicPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => end($heuristicPicture[Symbol::WHITE]),
            Symbol::BLACK => end($heuristicPicture[Symbol::BLACK]),
        ];

        return $this->sample;
    }
}
