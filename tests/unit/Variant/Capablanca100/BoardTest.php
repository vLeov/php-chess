<?php

namespace Chess\Tests\Unit\Variant\Capablanca100;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca100\Board;

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
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4()
    {
        $board = new Board();

        $board->play('w', 'e4');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7_Nh3()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');
        $board->play('w', 'Nh3');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7_Nh3_Nc8()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc8');

        $expected = [
            9 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7_Nh3_Nc8_d4_b8()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc8');
        $board->play('w', 'd4');
        $board->play('b', 'b8');

        $expected = [
            9 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' p ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' P ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' . ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7___b8_Ad2()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc8');
        $board->play('w', 'd4');
        $board->play('b', 'b8');
        $board->play('w', 'Ad2');

        $expected = [
            9 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' p ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' P ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' A ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' . ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7___Ad2_Ci8()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc8');
        $board->play('w', 'd4');
        $board->play('b', 'b8');
        $board->play('w', 'Ad2');
        $board->play('b', 'Ci8');

        $expected = [
            9 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' . ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' p ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' c ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' P ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' A ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' . ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_e4_e7___Ci8_Af3()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc8');
        $board->play('w', 'd4');
        $board->play('b', 'b8');
        $board->play('w', 'Ad2');
        $board->play('b', 'Ci8');
        $board->play('w', 'Af3');

        $expected = [
            9 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' . ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' p ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' c ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' P ', ' P ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' A ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' . ', ' . ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' . ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_Nj3_e7___Ci8_O_O()
    {
        $board = new Board();

        $board->play('w', 'Nj3');
        $board->play('b', 'e7');
        $board->play('w', 'Ci3');
        $board->play('b', 'Nc8');
        $board->play('w', 'h3');
        $board->play('b', 'b8');
        $board->play('w', 'Bh2');
        $board->play('b', 'Ci8');
        $board->play('w', 'O-O');

        $expected = [
            9 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' . ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' p ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' c ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' C ', ' N ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' B ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' . ', ' . ', ' R ', ' K ', ' . ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_a4_j7___bxc10_ixj1()
    {
        $board = new Board();

        $board->play('w', 'a4');
        $board->play('b', 'j7');
        $board->play('w', 'a5');
        $board->play('b', 'j6');
        $board->play('w', 'a6');
        $board->play('b', 'j5');
        $board->play('w', 'a7');
        $board->play('b', 'j4');
        $board->play('w', 'a8');
        $board->play('b', 'j3');
        $board->play('w', 'axb9');
        $board->play('b', 'jxi2');
        $board->play('w', 'bxc10=Q');
        $board->play('b', 'ixj1=Q');

        $expected = [
            9 => [ ' r ', ' n ', ' Q ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' . ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' . ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' . ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' q ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_a4_j7___Nh3_i1()
    {
        $board = new Board();

        $board->play('w', 'a4');
        $board->play('b', 'j7');
        $board->play('w', 'a5');
        $board->play('b', 'j6');
        $board->play('w', 'a6');
        $board->play('b', 'j5');
        $board->play('w', 'a7');
        $board->play('b', 'j4');
        $board->play('w', 'a8');
        $board->play('b', 'j3');
        $board->play('w', 'axb9');
        $board->play('b', 'Nc8');
        $board->play('w', 'b10=Q');
        $board->play('b', 'jxi2');
        $board->play('w', 'Nh3');
        $board->play('b', 'i1=Q');

        $expected = [
            9 => [ ' r ', ' Q ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' . ' ],
            7 => [ ' . ', ' . ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' . ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' . ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' q ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_f4_f7___Nh3()
    {
        $board = new Board();

        $board->play('w', 'f4');
        $board->play('b', 'f7');
        $board->play('w', 'Nh3');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_f4_f7___Cg3_Bf9()
    {
        $board = new Board();

        $board->play('w', 'f4');
        $board->play('b', 'f7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nh8');
        $board->play('w', 'Cg3');
        $board->play('b', 'Bf9');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' . ', ' c ', ' . ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' b ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' n ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' C ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' . ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_f4_f7___Bf2_Ci8()
    {
        $board = new Board();

        $board->play('w', 'f4');
        $board->play('b', 'f7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nh8');
        $board->play('w', 'Cg3');
        $board->play('b', 'Bf9');
        $board->play('w', 'Bf2');
        $board->play('b', 'Ci8');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' . ', ' . ', ' . ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' b ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' n ', ' c ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' C ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' B ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' . ', ' . ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_f4_f7___Cg8_Cg3()
    {
        $board = new Board();

        $board->play('w', 'f4');
        $board->play('b', 'f7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Cg8');
        $board->play('w', 'Cg3');
        $board->play('b', 'Cj8');

        $expected = [
            9 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' . ', ' n ', ' r ' ],
            8 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ' ],
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' c ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' C ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' . ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_f4_f7___Cg8_legal_g8()
    {
        $board = new Board();

        $board->play('w', 'f4');
        $board->play('b', 'f7');
        $board->play('w', 'Nh3');
        $board->play('b', 'Cg8');
        $board->play('w', 'Cg3');

        $expected = (object) [
            'color' => 'b',
            'id' => 'C',
            'fen' => [
                'g7' => 'rnabqkb1nr/ppppp1pppp/10/5pc3/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'g6' => 'rnabqkb1nr/ppppp1pppp/10/5p4/6c3/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'g5' => 'rnabqkb1nr/ppppp1pppp/10/5p4/10/6c3/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'g4' => 'rnabqkb1nr/ppppp1pppp/10/5p4/10/10/5Pc3/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'g3' => 'rnabqkb1nr/ppppp1pppp/10/5p4/10/10/5P4/6cN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'f8' => 'rnabqkb1nr/ppppp1pppp/5c4/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'e8' => 'rnabqkb1nr/ppppp1pppp/4c5/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'd8' => 'rnabqkb1nr/ppppp1pppp/3c6/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'c8' => 'rnabqkb1nr/ppppp1pppp/2c7/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'b8' => 'rnabqkb1nr/ppppp1pppp/1c8/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'a8' => 'rnabqkb1nr/ppppp1pppp/c9/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'h8' => 'rnabqkb1nr/ppppp1pppp/7c2/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'i8' => 'rnabqkb1nr/ppppp1pppp/8c1/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'j8' => 'rnabqkb1nr/ppppp1pppp/9c/5p4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'e7' => 'rnabqkb1nr/ppppp1pppp/10/4cp4/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'f6' => 'rnabqkb1nr/ppppp1pppp/10/5p4/5c4/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'h6' => 'rnabqkb1nr/ppppp1pppp/10/5p4/7c2/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
                'i7' => 'rnabqkb1nr/ppppp1pppp/10/5p2c1/10/10/5P4/6CN2/PPPPP1PPPP/RNABQKB2R w KQkq -',
            ],
        ];

        $this->assertEquals($expected, $board->legal('g8'));
    }

    /*
    |--------------------------------------------------------------------------
    | playLan()
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @test
     */
    public function play_lan_w_f2f4()
    {
        $board = new Board();

        $this->assertTrue($board->playLan('w', 'f2f4'));
    }

    /**
     * @test
     */
    public function play_lan_w_f2f4_f9f7()
    {
        $board = new Board();

        $this->assertTrue($board->playLan('w', 'f2f4'));
        $this->assertTrue($board->playLan('b', 'f9f7'));
    }
}
