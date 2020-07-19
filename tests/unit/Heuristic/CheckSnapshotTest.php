<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Board;
use PGNChess\Checkmate\Fool as FoolCheckmate;
use PGNChess\Checkmate\Scholar as ScholarCheckmate;
use PGNChess\Heuristic\CheckSnapshot;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class CheckSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function benko_gambit()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new CheckSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $movetext = (new FoolCheckmate(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new CheckSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 1,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $movetext = (new ScholarCheckmate(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new CheckSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
