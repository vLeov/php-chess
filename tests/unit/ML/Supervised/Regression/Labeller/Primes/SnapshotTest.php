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
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.06,
            ],
            [
                Symbol::WHITE => 0.04,
                Symbol::BLACK => 0.4,
            ],
            [
                Symbol::WHITE => 0.02,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.43,
                Symbol::BLACK => 0.15,
            ],
            [
                Symbol::WHITE => 0.21,
                Symbol::BLACK => 0.14,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
