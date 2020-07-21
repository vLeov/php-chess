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
                Symbol::WHITE => 0.45,
                Symbol::BLACK => 0.69,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.86,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.76,
            ],
            [
                Symbol::WHITE => 0.1,
                Symbol::BLACK => 0.45,
            ],
            [
                Symbol::WHITE => 0.21,
                Symbol::BLACK => 0.45,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
