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
                Symbol::WHITE => 0.67,
                Symbol::BLACK => 0.33,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.13,
            ],
            [
                Symbol::WHITE => 0.06,
                Symbol::BLACK => 0.67,
            ],
            [
                Symbol::WHITE => 0.07,
                Symbol::BLACK => 0.02,
            ],
            [
                Symbol::WHITE => 0.1,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
