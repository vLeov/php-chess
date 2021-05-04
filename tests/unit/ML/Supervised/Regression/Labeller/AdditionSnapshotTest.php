<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AdditionSnapshot;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class AdditionSnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function open_sicilian()
    {
        $movetext = (new OpenSicilian(new Board()))
                        ->play()
                        ->getMovetext();

        $snapshot = (new AdditionSnapshot($movetext))->take();

        $expected = [
            [
                Symbol::WHITE => 0.71,
                Symbol::BLACK => 0.33,
            ],
            [
                Symbol::WHITE => 1,
                Symbol::BLACK => 0.01,
            ],
            [
                Symbol::WHITE => 0.65,
                Symbol::BLACK => 0.08,
            ],
            [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0.59,
            ],
            [
                Symbol::WHITE => 0.21,
                Symbol::BLACK => 0.57,
            ],
        ];

        $this->assertEquals($expected, $snapshot);
    }
}
