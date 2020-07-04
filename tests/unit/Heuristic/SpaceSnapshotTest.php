<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Heuristic\SpaceSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class SpaceSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $expected = [
            [
                Symbol::WHITE => 12,
                Symbol::BLACK => 12,
            ],
            [
                Symbol::WHITE => 16,
                Symbol::BLACK => 16,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 16,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 16,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 17,
            ],
            [
                Symbol::WHITE => 18,
                Symbol::BLACK => 18,
            ],
            [
                Symbol::WHITE => 19,
                Symbol::BLACK => 20,
            ],
            [
                Symbol::WHITE => 21,
                Symbol::BLACK => 18,
            ],
        ];

        $snapshot = (new SpaceSnapshot(
            '1.Nf3 Nf6 2.c4 c5 3.g3 b6 4.Bg2 Bb7 5.O-O e6 6.Nc3 a6 7.d4 cxd4 8.Qxd4 d6'
        ))->take();

        $this->assertEquals($expected, $snapshot);
    }
}
