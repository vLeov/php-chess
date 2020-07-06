<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\AttackSnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

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
                Symbol::WHITE => 1,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 2,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 2,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 2,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 2,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 4,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 3,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 3,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
