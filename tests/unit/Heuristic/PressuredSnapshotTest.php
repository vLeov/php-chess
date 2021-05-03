<?php

namespace Chess\Tests\Unit\Heuristic;

use Chess\Board;
use Chess\Heuristic\PressuredSnapshot;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class PressuredSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new PressuredSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.25,
                Symbol::BLACK => 0.25,
            ],
            [
                Symbol::WHITE => 0.5,
                Symbol::BLACK => 0.25,
            ],
            [
                Symbol::WHITE => 0.5,
                Symbol::BLACK => 0.25,
            ],
            [
                Symbol::WHITE => 0.5,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.5,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.25,
            ],
            [
                Symbol::WHITE => 0.75,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.75,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
