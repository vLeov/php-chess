<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\KingSafetySnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class KingSafetySnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new KingSafetySnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 15.13,
                Symbol::BLACK => 16.13,
            ],
            [
                Symbol::WHITE => 15.13,
                Symbol::BLACK => 16.13,
            ],
            [
                Symbol::WHITE => 15.13,
                Symbol::BLACK => 16.13,
            ],
            [
                Symbol::WHITE => 15.13,
                Symbol::BLACK => 16.13,
            ],
            [
                Symbol::WHITE => 15.13,
                Symbol::BLACK => 16.13,
            ],
            [
                Symbol::WHITE => 15.13,
                Symbol::BLACK => 15.13,
            ],
            [
                Symbol::WHITE => 14.13,
                Symbol::BLACK => 15.13,
            ],
            [
                Symbol::WHITE => 6.2,
                Symbol::BLACK => 15.13,
            ],
            [
                Symbol::WHITE => 5.2,
                Symbol::BLACK => 15.13,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
