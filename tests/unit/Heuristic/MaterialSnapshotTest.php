<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Heuristic\MaterialSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class MaterialSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $expected = [
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 39.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 39.06,
                Symbol::BLACK => 39.06,
            ],
        ];

        $snapshot = (new MaterialSnapshot(
            '1.Nf3 Nf6 2.c4 c5 3.g3 b6 4.Bg2 Bb7 5.O-O e6 6.Nc3 a6 7.d4 cxd4 8.Qxd4 d6'
        ))->take();

        $this->assertEquals($expected, $snapshot);
    }
}
