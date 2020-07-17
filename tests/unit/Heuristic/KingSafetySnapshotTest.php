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
                Symbol::WHITE => 5,
                Symbol::BLACK => 6,
            ],
            [
                Symbol::WHITE => 5,
                Symbol::BLACK => 6,
            ],
            [
                Symbol::WHITE => 5,
                Symbol::BLACK => 6,
            ],
            [
                Symbol::WHITE => 5,
                Symbol::BLACK => 6,
            ],
            [
                Symbol::WHITE => 4,
                Symbol::BLACK => 6,
            ],
            [
                Symbol::WHITE => 4,
                Symbol::BLACK => 5,
            ],
            [
                Symbol::WHITE => -1,
                Symbol::BLACK => 5,
            ],
            [
                Symbol::WHITE => 4,
                Symbol::BLACK => 5,
            ],
            [
                Symbol::WHITE => 3,
                Symbol::BLACK => 5,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
