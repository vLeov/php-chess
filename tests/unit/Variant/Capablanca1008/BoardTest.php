<?php

namespace Chess\Tests\Unit\Variant\Capablanca1008;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca1008\Board;

class BoardTest extends AbstractUnitTestCase
{
    /*
    |--------------------------------------------------------------------------
    | getPieces()
    |--------------------------------------------------------------------------
    |
    | Gets all pieces.
    |
    */

    /**
     * @test
     */
    public function get_pieces()
    {
        $board = new Board();

        $this->assertSame(40, count($board->getPieces()));
    }

    /*
    |--------------------------------------------------------------------------
    | play()
    |--------------------------------------------------------------------------
    |
    | Legal moves return true.
    |
    */

    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $expected = [
            7 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }
}
