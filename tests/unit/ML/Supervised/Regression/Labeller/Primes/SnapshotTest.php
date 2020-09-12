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
                Symbol::WHITE => 0.43,
                Symbol::BLACK => 0.34,
            ],
            [
                Symbol::WHITE => 0.65,
                Symbol::BLACK => 0.1,
            ],
            [
                Symbol::WHITE => 0.11,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.55,
                Symbol::BLACK => 0.12,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.11,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
