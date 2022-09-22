<?php

namespace Chess\Tests\Unit\Variant\Chess960;

use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Chess960\Board;
use Chess\Variant\Chess960\StartPosition;

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
        $startPosition = (new StartPosition())->create();
        $board = new Board($startPosition);
        $pieces = $board->getPieces();

        $this->assertSame(32, count($pieces));
    }

    /*
    |--------------------------------------------------------------------------
    | getCastlingRule()
    |--------------------------------------------------------------------------
    |
    | Returns the castling rule.
    |
    */

    /**
     * @test
     */
    public function get_castling_rule_R_B_B_K_R_Q_N_N()
    {
        $startPosition = ['R', 'B', 'B', 'K', 'R', 'Q', 'N', 'N'];

        $castlingRule = (new Board($startPosition))->getCastlingRule();

        $expected = [
            Color::W => [
                Piece::K => [
                    Castle::SHORT => [
                        'sqs' => [ 'f1', 'g1' ],
                        'sq' => [
                            'current' => 'd1',
                            'next' => 'g1',
                        ],
                    ],
                    Castle::LONG => [
                        'sqs' => [ 'b1', 'c1' ],
                        'sq' => [
                            'current' => 'd1',
                            'next' => 'c1',
                        ],
                    ],
                ],
                Piece::R => [
                    Castle::SHORT => [
                        'sq' => [
                            'current' => 'e1',
                            'next' => 'f1',
                        ],
                    ],
                    Castle::LONG => [
                        'sq' => [
                            'current' => 'a1',
                            'next' => 'd1',
                        ],
                    ],
                ],
            ],
            Color::B => [
                Piece::K => [
                    Castle::SHORT => [
                        'sqs' => [ 'f8', 'g8' ],
                        'sq' => [
                            'current' => 'd8',
                            'next' => 'g8',
                        ],
                    ],
                    Castle::LONG => [
                        'sqs' => [ 'b8', 'c8' ],
                        'sq' => [
                            'current' => 'd8',
                            'next' => 'c8',
                        ],
                    ],
                ],
                Piece::R => [
                    Castle::SHORT => [
                        'sq' => [
                            'current' => 'e8',
                            'next' => 'f8',
                        ],
                    ],
                    Castle::LONG => [
                        'sq' => [
                            'current' => 'a8',
                            'next' => 'd8',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $castlingRule);
    }

    /**
     * @test
     */
    public function get_castling_rule_Q_R_B_K_R_B_N_N()
    {
        $startPosition = ['Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N'];

        $castlingRule = (new Board($startPosition))->getCastlingRule();

        $expected = [
            Color::W => [
                Piece::K => [
                    Castle::SHORT => [
                        'sqs' => [ 'f1', 'g1' ],
                        'sq' => [
                            'current' => 'd1',
                            'next' => 'g1',
                        ],
                    ],
                    Castle::LONG => [
                        'sqs' => [ 'c1' ],
                        'sq' => [
                            'current' => 'd1',
                            'next' => 'c1',
                        ],
                    ],
                ],
                Piece::R => [
                    Castle::SHORT => [
                        'sq' => [
                            'current' => 'e1',
                            'next' => 'f1',
                        ],
                    ],
                    Castle::LONG => [
                        'sq' => [
                            'current' => 'b1',
                            'next' => 'd1',
                        ],
                    ],
                ],
            ],
            Color::B => [
                Piece::K => [
                    Castle::SHORT => [
                        'sqs' => [ 'f8', 'g8' ],
                        'sq' => [
                            'current' => 'd8',
                            'next' => 'g8',
                        ],
                    ],
                    Castle::LONG => [
                        'sqs' => [ 'c8' ],
                        'sq' => [
                            'current' => 'd8',
                            'next' => 'c8',
                        ],
                    ],
                ],
                Piece::R => [
                    Castle::SHORT => [
                        'sq' => [
                            'current' => 'e8',
                            'next' => 'f8',
                        ],
                    ],
                    Castle::LONG => [
                        'sq' => [
                            'current' => 'b8',
                            'next' => 'd8',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $castlingRule);
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
    public function play_Q_R_B_K_R_B_N_N_e4_e5()
    {
        $startPosition = ['Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N'];

        $board = new Board($startPosition);

        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $expected = [
            7 => [ ' q ', ' r ', ' b ', ' k ', ' r ', ' b ', ' n ', ' n ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' Q ', ' R ', ' B ', ' K ', ' R ', ' B ', ' N ', ' N ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_B_B_N_R_K_R_Q_N_e4_e5()
    {
        $startPosition = ['B', 'B', 'N', 'R', 'K', 'R', 'Q', 'N'];

        $board = new Board($startPosition);

        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $expected = [
            7 => [ ' b ', ' b ', ' n ', ' r ', ' k ', ' r ', ' q ', ' n ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' B ', ' B ', ' N ', ' R ', ' K ', ' R ', ' Q ', ' N ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_N_R_N_Q_K_B_B_R_e4_Nd6_Bc4_e6_f3_Qe7_Bf2()
    {
        $startPosition = ['N', 'R', 'N', 'Q', 'K', 'B', 'B', 'R'];

        $board = new Board($startPosition);

        $board->play('w', 'e4');
        $board->play('b', 'Nd6');

        $board->play('w', 'Bc4');
        $board->play('b', 'e6');

        $board->play('w', 'f3');
        $board->play('b', 'Qe7');

        $board->play('w', 'Bf2');

        $expected = [
            7 => [ ' n ', ' r ', ' . ', ' . ', ' k ', ' b ', ' b ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' q ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' n ', ' p ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' B ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' B ', ' P ', ' P ' ],
            0 => [ ' N ', ' R ', ' N ', ' Q ', ' K ', ' . ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_N_R_N_Q_K_B_B_R_e4_Nd6_Bc4_e6_f3_Qe7_Bf2_O_O_O()
    {
        $startPosition = ['N', 'R', 'N', 'Q', 'K', 'B', 'B', 'R'];

        $board = new Board($startPosition);

        $board->play('w', 'e4');
        $board->play('b', 'Nd6');

        $board->play('w', 'Bc4');
        $board->play('b', 'e6');

        $board->play('w', 'f3');
        $board->play('b', 'Qe7');

        $board->play('w', 'Bf2');
        $board->play('b', 'O-O-O');

        $expected = [
            7 => [ ' n ', ' . ', ' k ', ' r ', ' . ', ' b ', ' b ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' q ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' n ', ' p ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' B ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' B ', ' P ', ' P ' ],
            0 => [ ' N ', ' R ', ' N ', ' Q ', ' K ', ' . ', ' . ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_B_B_R_Q_N_N_K_R_Ne3_Ne6_O_O()
    {
        $startPosition = ['B', 'B', 'R', 'Q', 'N', 'N', 'K', 'R'];

        $board = new Board($startPosition);

        $this->assertTrue($board->play('w', 'Ne3'));
        $this->assertTrue($board->play('b', 'Ne6'));
        $this->assertTrue($board->play('w', 'O-O'));

        $expected = [
            7 => [ ' b ', ' b ', ' r ', ' q ', ' n ', ' . ', ' k ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' n ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' B ', ' B ', ' R ', ' Q ', ' N ', ' R ', ' K ', ' . ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_B_Q_N_R_K_B_R_N_e3_g6_Bc4_Bh6()
    {
        $startPosition = ['B', 'Q', 'N', 'R', 'K', 'B', 'R', 'N'];

        $board = new Board($startPosition);

        $this->assertTrue($board->play('w', 'e3'));
        $this->assertTrue($board->play('b', 'g6'));
        $this->assertTrue($board->play('w', 'Bc4'));
        $this->assertTrue($board->play('b', 'Bh6'));

        $expected = [
            7 => [ ' b ', ' q ', ' n ', ' r ', ' k ', ' . ', ' r ', ' n ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' . ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' p ', ' b ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' B ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' B ', ' Q ', ' N ', ' R ', ' K ', ' . ', ' R ', ' N ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }
}
