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
                Symbol::WHITE => 0.86,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.86,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.86,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.86,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.71,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.71,
                Symbol::BLACK => 0.86,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.86,
            ],
            [
                Symbol::WHITE => 0.71,
                Symbol::BLACK => 0.86,
            ],
            [
                Symbol::WHITE => 0.57,
                Symbol::BLACK => 0.86,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
