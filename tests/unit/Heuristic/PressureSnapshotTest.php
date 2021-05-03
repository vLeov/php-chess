<?php

namespace Chess\Tests\Unit\Heuristic;

use Chess\Board;
use Chess\Heuristic\PressureSnapshot;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class PressureSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new PressureSnapshot($movetext))->take();

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
                Symbol::WHITE => 0.25,
                Symbol::BLACK => 0.5,
            ],
            [
                Symbol::WHITE => 0.25,
                Symbol::BLACK => 0.5,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.5,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.5,
            ],
            [
                Symbol::WHITE => 0.25,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.75,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.75,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
