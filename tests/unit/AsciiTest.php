<?php

namespace Chess\Tests\Unit;

use Chess\Ascii;
use Chess\Board;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Benoni\FianchettoVariation as BenoniFianchettoVariation;
use Chess\Tests\Sample\Opening\FrenchDefense\Classical as FrenchDefenseClassical;

class AsciiTest extends AbstractUnitTestCase
{
    /*
    |--------------------------------------------------------------------------
    | fromAlgebraicToIndex()
    |--------------------------------------------------------------------------
    |
    | Returns the ASCII array indexes of a square described in algebraic notation.
    |
    */

    /**
     * @test
     */
    public function from_algebraic_to_index_a1()
    {
        $this->assertSame([0, 0], (new Ascii())->fromAlgebraicToIndex('a1'));
    }

    /**
     * @test
     */
    public function from_algebraic_to_index_a2()
    {
        $this->assertSame([1, 0], (new Ascii())->fromAlgebraicToIndex('a2'));
    }

    /**
     * @test
     */
    public function from_algebraic_to_index_h7()
    {
        $this->assertSame([6, 7], (new Ascii())->fromAlgebraicToIndex('h7'));
    }

    /**
     * @test
     */
    public function from_algebraic_to_index_h8()
    {
        $this->assertSame([7, 7], (new Ascii())->fromAlgebraicToIndex('h8'));
    }

    /*
    |--------------------------------------------------------------------------
    | fromIndexToAlgebraic()
    |--------------------------------------------------------------------------
    |
    | Returns the square in algebraic notation corresponding to the given ASCII array indexes.
    |
    */

    /**
     * @test
     */
    public function from_index_to_algebraic_0_0()
    {
        $this->assertSame('a1', (new Ascii())->fromIndexToAlgebraic(0, 0));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_1_0()
    {
        $this->assertSame('a2', (new Ascii())->fromIndexToAlgebraic(1, 0));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_6_7()
    {
        $this->assertSame('h7', (new Ascii())->fromIndexToAlgebraic(6, 7));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_7_7()
    {
        $this->assertSame('h8', (new Ascii())->fromIndexToAlgebraic(7, 7));
    }

    /*
    |--------------------------------------------------------------------------
    | setArrayElem()
    |--------------------------------------------------------------------------
    |
    | Sets a piece in a specific square in the given ASCII array.
    |
    */

    /**
     * @test
     */
    public function e4_e5_set_array_elem()
    {
        $array = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
        ];

        $expected = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' . ', ' R ' ],
        ];

        (new Ascii())
            ->setArrayElem(' . ', 'g1', $array)
            ->setArrayElem(' N ', 'f3', $array);

        $this->assertSame($expected, $array);
    }

    /*
    |--------------------------------------------------------------------------
    | toArray()
    |--------------------------------------------------------------------------
    |
    | Returns an ASCII array from a Chess\Board object.
    |
    */

    /**
     * @test
     */
    public function to_array_e4_e5()
    {
        $board = new Board();
        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $array = (new Ascii())->toArray($board);

        $expected = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function to_array_benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $array = (new Ascii())->toArray($board);

        $expected = [
            7 => [ ' r ', ' n ', ' . ', ' q ', ' k ', ' b ', ' . ', ' r ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' p ', ' . ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' p ', ' . ', ' n ', ' p ', ' . ' ],
            4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' P ', ' . ' ],
            1 => [ ' P ', ' P ', ' . ', ' . ', ' . ', ' P ', ' . ', ' P ' ],
            0 => [ ' R ', ' . ', ' B ', ' Q ', ' . ', ' K ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function to_array_benoni_fianchetto_variation()
    {
        $board = (new BenoniFianchettoVariation(new Board()))->play();

        $array = (new Ascii())->toArray($board);

        $expected = [
            7 => [ ' r ', ' . ', ' b ', ' q ', ' r ', ' . ', ' k ', ' . ' ],
            6 => [ ' . ', ' p ', ' . ', ' n ', ' . ', ' p ', ' b ', ' p ' ],
            5 => [ ' p ', ' . ', ' . ', ' p ', ' . ', ' n ', ' p ', ' . ' ],
            4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' P ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' P ', ' . ' ],
            1 => [ ' . ', ' P ', ' . ', ' N ', ' P ', ' P ', ' B ', ' P ' ],
            0 => [ ' R ', ' . ', ' B ', ' Q ', ' . ', ' R ', ' K ', ' . ' ],
        ];

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function to_array_french_defense_classical()
    {
        $board = (new FrenchDefenseClassical(new Board()))->play();

        $array = (new Ascii())->toArray($board);

        $expected = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' . ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' . ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' n ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' P ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' . ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' . ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $array);
    }

    /*
    |--------------------------------------------------------------------------
    | toBoard()
    |--------------------------------------------------------------------------
    |
    | Returns a Chess\Board object from an ASCII array.
    |
    */

    /**
     * @test
     */
    public function to_board_e4_e5()
    {
        $expected = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
        ];

        $castle = [
            'w' => [
                'isCastled' => false,
                'O-O' => true,
                'O-O-O' => true,
            ],
            'b' => [
                'isCastled' => false,
                'O-O' => true,
                'O-O-O' => true,
            ],
        ];

        $board = (new Ascii())->toBoard($expected, 'w', $castle);
        $array = (new Ascii())->toArray($board);

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function to_board_benko_gambit()
    {
        $expected = [
            7 => [ ' r ', ' n ', ' . ', ' q ', ' k ', ' b ', ' . ', ' r ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' p ', ' . ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' p ', ' . ', ' n ', ' p ', ' . ' ],
            4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' P ', ' . ' ],
            1 => [ ' P ', ' P ', ' . ', ' . ', ' . ', ' P ', ' . ', ' P ' ],
            0 => [ ' R ', ' . ', ' B ', ' Q ', ' . ', ' K ', ' N ', ' R ' ],
        ];

        $castle = [
            'w' => [
                'isCastled' => false,
                'O-O' => false,
                'O-O-O' => false,
            ],
            'b' => [
                'isCastled' => false,
                'O-O' => true,
                'O-O-O' => true,
            ],
        ];

        $board = (new Ascii())->toBoard($expected, 'b', $castle);
        $array = (new Ascii())->toArray($board);

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function to_board_benoni_fianchetto_variation()
    {
        $expected = [
            7 => [ ' r ', ' . ', ' b ', ' q ', ' r ', ' . ', ' k ', ' . ' ],
            6 => [ ' . ', ' p ', ' . ', ' n ', ' . ', ' p ', ' b ', ' p ' ],
            5 => [ ' p ', ' . ', ' . ', ' p ', ' . ', ' n ', ' p ', ' . ' ],
            4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' P ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' P ', ' . ' ],
            1 => [ ' . ', ' P ', ' . ', ' N ', ' P ', ' P ', ' B ', ' P ' ],
            0 => [ ' R ', ' . ', ' B ', ' Q ', ' . ', ' R ', ' K ', ' . ' ],
        ];

        $castle = [
            'w' => [
                'isCastled' => true,
                'O-O' => false,
                'O-O-O' => false,
            ],
            'b' => [
                'isCastled' => true,
                'O-O' => false,
                'O-O-O' => false,
            ],
        ];

        $board = (new Ascii())->toBoard($expected, 'b', $castle);
        $array = (new Ascii())->toArray($board);

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function to_board_french_defense_classical()
    {
        $expected = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' . ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' . ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' n ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' P ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' . ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' . ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
        ];

        $board = (new Ascii())->toBoard($expected, 'w');
        $array = (new Ascii())->toArray($board);

        $this->assertSame($expected, $array);
    }
}
