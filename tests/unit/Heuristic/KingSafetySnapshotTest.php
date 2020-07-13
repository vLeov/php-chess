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
                Symbol::WHITE => 84,
                Symbol::BLACK => 168,
            ],
            [
                Symbol::WHITE => 84,
                Symbol::BLACK => 168,
            ],
            [
                Symbol::WHITE => 84,
                Symbol::BLACK => 168,
            ],
            [
                Symbol::WHITE => 84,
                Symbol::BLACK => 168,
            ],
            [
                Symbol::WHITE => 84,
                Symbol::BLACK => 168,
            ],
            [
                Symbol::WHITE => 84,
                Symbol::BLACK => 84,
            ],
            [
                Symbol::WHITE => 42,
                Symbol::BLACK => 84,
            ],
            [
                Symbol::WHITE => 12,
                Symbol::BLACK => 84,
            ],
            [
                Symbol::WHITE => 6,
                Symbol::BLACK => 84,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
