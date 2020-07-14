<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\ConnectivitySnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

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
                Symbol::WHITE => 34,
                Symbol::BLACK => 39,
            ],
            [
                Symbol::WHITE => 34,
                Symbol::BLACK => 39,
            ],
            [
                Symbol::WHITE => 35,
                Symbol::BLACK => 38,
            ],
            [
                Symbol::WHITE => 34,
                Symbol::BLACK => 40,
            ],
            [
                Symbol::WHITE => 33,
                Symbol::BLACK => 35,
            ],
            [
                Symbol::WHITE => 35,
                Symbol::BLACK => 35,
            ],
            [
                Symbol::WHITE => 27,
                Symbol::BLACK => 33,
            ],
            [
                Symbol::WHITE => 28,
                Symbol::BLACK => 33,
            ],
            [
                Symbol::WHITE => 29,
                Symbol::BLACK => 33,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
