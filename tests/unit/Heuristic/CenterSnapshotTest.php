<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\CenterSnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class CenterSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new CenterSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 2,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 2,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 2,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
