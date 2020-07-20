<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\ConnectivitySnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\Benoni\BenkoGambit;

class ConnectivitySnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new ConnectivitySnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0.54,
                Symbol::BLACK => 0.92,
            ],
            [
                Symbol::WHITE => 0.54,
                Symbol::BLACK => 0.92,
            ],
            [
                Symbol::WHITE => 0.62,
                Symbol::BLACK => 0.85,
            ],
            [
                Symbol::WHITE => 0.54,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.46,
                Symbol::BLACK => 0.62,
            ],
            [
                Symbol::WHITE => 0.62,
                Symbol::BLACK => 0.62,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.46,
            ],
            [
                Symbol::WHITE => 0.08,
                Symbol::BLACK => 0.46,
            ],
            [
                Symbol::WHITE => 0.15,
                Symbol::BLACK => 0.46,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
