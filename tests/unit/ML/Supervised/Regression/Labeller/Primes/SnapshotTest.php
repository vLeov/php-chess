<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Labeller\Primes;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\Primes\Snapshot as PrimesLabellerSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class SnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function open_sicilian()
    {
        $movetext = (new OpenSicilian(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new PrimesLabellerSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0.4,
                Symbol::BLACK => 0.35,
            ],
            [
                Symbol::WHITE => 0.49,
                Symbol::BLACK => 0.07,
            ],
            [
                Symbol::WHITE => 0.01,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.65,
                Symbol::BLACK => 0.01,
            ],
            [
                Symbol::WHITE => 0.18,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
