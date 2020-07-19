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
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.5,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.5,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0,
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
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
