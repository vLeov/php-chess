<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Heuristic\MaterialSnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class MaterialSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new MaterialSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 40.06,
            ],
            [
                Symbol::WHITE => 40.06,
                Symbol::BLACK => 39.06,
            ],
            [
                Symbol::WHITE => 39.06,
                Symbol::BLACK => 38.06,
            ],
            [
                Symbol::WHITE => 39.06,
                Symbol::BLACK => 38.06,
            ],
            [
                Symbol::WHITE => 35.73,
                Symbol::BLACK => 38.06,
            ],
            [
                Symbol::WHITE => 35.73,
                Symbol::BLACK => 34.73,
            ],
            [
                Symbol::WHITE => 35.73,
                Symbol::BLACK => 34.73,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
