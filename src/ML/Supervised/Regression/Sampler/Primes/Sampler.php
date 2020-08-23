<?php

namespace PGNChess\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\Event\Check as CheckEvent;
use PGNChess\Event\PieceCapture as PieceCaptureEvent;
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
        $picture = (new StandardHeuristicPicture($this->board->getMovetext()))->take();

        $wEnd = end($picture[Symbol::WHITE]);
        $bEnd = end($picture[Symbol::BLACK]);

        $this->sample = [
            Symbol::WHITE => array_merge(
                $wEnd, [
                    (new PieceCaptureEvent($this->board))->capture(Symbol::WHITE),
                    (new CheckEvent($this->board))->capture(Symbol::WHITE),
                ]
            ),
            Symbol::BLACK => array_merge(
                $bEnd, [
                    (new PieceCaptureEvent($this->board))->capture(Symbol::BLACK),
                    (new CheckEvent($this->board))->capture(Symbol::BLACK),
                ]
            ),
        ];

        return $this->sample;
    }
}
