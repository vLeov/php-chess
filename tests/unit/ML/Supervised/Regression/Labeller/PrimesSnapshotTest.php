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
                Symbol::WHITE => 0.64,
                Symbol::BLACK => 0.29,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.08,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.65,
            ],
            [
                Symbol::WHITE => 0.37,
                Symbol::BLACK => 0.31,
            ],
            [
                Symbol::WHITE => 0.39,
                Symbol::BLACK => 0.29,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
