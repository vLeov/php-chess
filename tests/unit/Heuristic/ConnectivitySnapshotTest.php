<?php

namespace Chess\Tests\Unit\Heuristic;

use Chess\Board;
use Chess\Heuristic\ConnectivitySnapshot;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

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
                Symbol::WHITE => 0.13,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.88,
            ],
            [
                Symbol::WHITE => 0.13,
                Symbol::BLACK => 0.75,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.75,
            ],
            [
                Symbol::WHITE => 0.63,
                Symbol::BLACK => 0.63,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.38,
            ],
            [
                Symbol::WHITE => 0.13,
                Symbol::BLACK => 0.38,
            ],
            [
                Symbol::WHITE => 0.25,
                Symbol::BLACK => 0.38,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
