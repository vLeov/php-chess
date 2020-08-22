<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Labeller\Primes;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\Primes\Decoder as PrimesLabelDecoder;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

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

        $this->assertEquals($expected, (new PrimesLabelDecoder($board))->decode(Symbol::BLACK, 571));
    }
}
