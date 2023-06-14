<?php

namespace Chess\Tests\Unit\Variant\Capablanca\FEN;

use Chess\Variant\Capablanca\FEN\StrToBoard;
use Chess\Tests\AbstractUnitTestCase;

class StrToBoardTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5()
    {
        $board = (new StrToBoard('rnabqkbcnr/pppp1ppppp/10/4p5/4P5/10/PPPP1PPPPP/RNABQKBCNR w KQkq e6'))
            ->create();

        $array = $board->toAsciiArray();

        $expected = [
            7 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $array);
    }
}
