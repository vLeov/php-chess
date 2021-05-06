<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\LinearCombinationDecoder;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;

class LinearCombinationDecoderTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_e4()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $expected = 'a6';

        $this->assertEquals($expected, (new LinearCombinationDecoder($board))->decode(Symbol::BLACK, 30));
    }
}
