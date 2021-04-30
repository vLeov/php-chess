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
                Symbol::WHITE => 0.62,
                Symbol::BLACK => 0.39,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.09,
                Symbol::BLACK => 0.48,
            ],
            [
                Symbol::WHITE => 0.09,
                Symbol::BLACK => 0.05,
            ],
            [
                Symbol::WHITE => 0.2,
                Symbol::BLACK => 0.04,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
