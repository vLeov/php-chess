<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\MaterialSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Unit\Sample\Opening\Benoni\BenkoGambit;

class MaterialSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new MaterialSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.81,
            ],
            [
                Symbol::WHITE => 0.81,
                Symbol::BLACK => 0.62,
            ],
            [
                Symbol::WHITE => 0.81,
                Symbol::BLACK => 0.62,
            ],
            [
                Symbol::WHITE => 0.19,
                Symbol::BLACK => 0.62,
            ],
            [
                Symbol::WHITE => 0.19,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.19,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
