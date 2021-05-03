<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\BinarySnapshot;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class BinarySnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function open_sicilian()
    {
        $movetext = (new OpenSicilian(new Board))
                        ->play()
                        ->getMovetext();

        $snapshot = (new BinarySnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0.04,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.1,
                Symbol::BLACK => 0.03,
            ],
            [
                Symbol::WHITE => 0.04,
                Symbol::BLACK => 1,
            ],
            [
                Symbol::WHITE => 0.96,
                Symbol::BLACK => 0,
            ],
            [
                Symbol::WHITE => 0.04,
                Symbol::BLACK => 0,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
