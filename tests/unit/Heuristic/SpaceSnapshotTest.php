<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\SpaceSnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

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
                Symbol::WHITE => 14,
                Symbol::BLACK => 12,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 15,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 17,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 16,
            ],
            [
                Symbol::WHITE => 17,
                Symbol::BLACK => 20,
            ],
            [
                Symbol::WHITE => 19,
                Symbol::BLACK => 21,
            ],
            [
                Symbol::WHITE => 22,
                Symbol::BLACK => 23,
            ],
            [
                Symbol::WHITE => 23,
                Symbol::BLACK => 20,
            ],
            [
                Symbol::WHITE => 24,
                Symbol::BLACK => 20,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
