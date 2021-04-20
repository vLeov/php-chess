<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller\Binary;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\Binary\Decoder as BinaryLabelDecoder;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;

class DecoderTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_e4()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $expected = 'e5';

        $this->assertEquals($expected, (new BinaryLabelDecoder($board))->decode(Symbol::BLACK, 181));
    }
}
