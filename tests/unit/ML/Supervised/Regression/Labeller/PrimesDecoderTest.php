<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Labeller;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\PrimesDecoder as PrimesDecoder;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class PrimesDecoderTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_e4()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $expected = 'Nc6';

        $this->assertEquals($expected, (new PrimesDecoder($board))->decode(Symbol::BLACK, 571));
    }
}
