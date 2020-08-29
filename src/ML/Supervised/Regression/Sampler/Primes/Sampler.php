<?php

namespace PGNChess\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\Event\Picture\Standard as StandardEventPicture;;
use PGNChess\Heuristic\Picture\Standard as StandardHeuristicPicture;;
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
        $eventPicture = (new StandardEventPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => array_merge(
                end($heuristicPicture[Symbol::WHITE]),
                end($eventPicture[Symbol::WHITE]),
            ),
            Symbol::BLACK => array_merge(
                end($heuristicPicture[Symbol::BLACK]),
                end($eventPicture[Symbol::BLACK]),
            ),
        ];

        return $this->sample;
    }
}
