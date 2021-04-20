<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller\Primes;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\Primes\Decoder as PrimesLabelDecoder;
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
        $expected = 'Na6';

        $this->assertEquals($expected, (new PrimesLabelDecoder($board))->decode(Symbol::BLACK, 76150));
    }
}
