<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\AttackSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Unit\Sample\Opening\Benoni\BenkoGambit;

class AttackSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new AttackSnapshot($movetext))->take();

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
