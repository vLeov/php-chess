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
                Symbol::BLACK => 0.07,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.29,
                Symbol::BLACK => 0.43,
            ],
            [
                Symbol::WHITE => 0.24,
                Symbol::BLACK => 0.04,
            ],
            [
                Symbol::WHITE => 0.32,
                Symbol::BLACK => 0.02,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
