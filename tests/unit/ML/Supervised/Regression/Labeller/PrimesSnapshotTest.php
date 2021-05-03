<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\PrimesSnapshot;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

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

        $snapshot = (new PrimesSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0.75,
                Symbol::BLACK => 0.57,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.08,
            ],
            [
                Symbol::WHITE => 0.05,
                Symbol::BLACK => 0.89,
            ],
            [
                Symbol::WHITE => 0.43,
                Symbol::BLACK => 0.02,
            ],
            [
                Symbol::WHITE => 0.52,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
