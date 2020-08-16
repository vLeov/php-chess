<?php

namespace PGNChess\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\Heuristic\AttackSnapshot;
use PGNChess\Heuristic\CenterSnapshot;
use PGNChess\Heuristic\ConnectivitySnapshot;
use PGNChess\Heuristic\KingSafetySnapshot;
use PGNChess\Heuristic\MaterialSnapshot;
use PGNChess\Event\Check as CheckEvent;
use PGNChess\Event\PieceCapture as PieceCaptureEvent;

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
        $attSnapshot = (new AttackSnapshot($this->board->getMovetext()))->take();
        $connSnapshot = (new ConnectivitySnapshot($this->board->getMovetext()))->take();
        $ctrSnapshot = (new CenterSnapshot($this->board->getMovetext()))->take();
        $kSafetySnapshot = (new KingSafetySnapshot($this->board->getMovetext()))->take();
        $mtlSnapshot = (new MaterialSnapshot($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => [
                end($attSnapshot)[Symbol::WHITE],
                end($connSnapshot)[Symbol::WHITE],
                end($ctrSnapshot)[Symbol::WHITE],
                end($attSnapshot)[Symbol::BLACK],
                end($kSafetySnapshot)[Symbol::WHITE],
                end($mtlSnapshot)[Symbol::WHITE],
                (new PieceCaptureEvent($this->board))->capture(Symbol::WHITE),
                (new CheckEvent($this->board))->capture(Symbol::WHITE),
            ],
            Symbol::BLACK => [
                end($attSnapshot)[Symbol::BLACK],
                end($connSnapshot)[Symbol::BLACK],
                end($ctrSnapshot)[Symbol::BLACK],
                end($attSnapshot)[Symbol::WHITE],
                end($kSafetySnapshot)[Symbol::BLACK],
                end($mtlSnapshot)[Symbol::BLACK],
                (new PieceCaptureEvent($this->board))->capture(Symbol::BLACK),
                (new CheckEvent($this->board))->capture(Symbol::BLACK),
            ],
        ];

        return $this->sample;
    }
}
