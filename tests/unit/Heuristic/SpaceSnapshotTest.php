<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\SpaceSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Unit\Sample\Opening\Benoni\BenkoGambit;

class SpaceSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new SpaceSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0.17,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.42,
                Symbol::BLACK => 0.25,
            ],
            [
                Symbol::WHITE => 0.42,
                Symbol::BLACK => 0.42,
            ],
            [
                Symbol::WHITE => 0.42,
                Symbol::BLACK => 0.33,
            ],
            [
                Symbol::WHITE => 0.42,
                Symbol::BLACK => 0.67,
            ],
            [
                Symbol::WHITE => 0.58,
                Symbol::BLACK => 0.75,
            ],
            [
                Symbol::WHITE => 0.83,
                Symbol::BLACK => 0.92,
            ],
            [
                Symbol::WHITE => 0.92,
                Symbol::BLACK => 0.67,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.67,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
