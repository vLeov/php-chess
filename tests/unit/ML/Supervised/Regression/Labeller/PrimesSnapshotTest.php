<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Labeller;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\PrimesSnapshot as PrimesLabellerSnapshot;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class PrimesSnapshotTest extends AbstractUnitTestCase
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
                Symbol::WHITE => 556.66,
                Symbol::BLACK => 563.66,
            ],
            [
                Symbol::WHITE => 572.66,
                Symbol::BLACK => 568.66,
            ],
            [
                Symbol::WHITE => 543.66,
                Symbol::BLACK => 565.66,
            ],
            [
                Symbol::WHITE => 546.66,
                Symbol::BLACK => 556.66,
            ],
            [
                Symbol::WHITE => 549.66,
                Symbol::BLACK => 556.66,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
