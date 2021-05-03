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
                Symbol::WHITE => 0.63,
                Symbol::BLACK => 0.03,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.33,
                Symbol::BLACK => 0.31,
            ],
            [
                Symbol::WHITE => 0.12,
                Symbol::BLACK => 0.08,
            ],
            [
                Symbol::WHITE => 0.2,
                Symbol::BLACK => 0.06,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
