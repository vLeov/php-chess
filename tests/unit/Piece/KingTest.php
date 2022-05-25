<?php

namespace Chess\Tests\Unit\Piece;

use Chess\Board;
use Chess\Piece\King;
use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class KingTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_CASTLE_LONG()
    {
        $rule = King::$castlingRule[Color::W];

        $this->assertSame($rule[Piece::K][Castle::LONG]['sqs'], [ 'b1', 'c1', 'd1' ]);
        $this->assertSame($rule[Piece::K][Castle::LONG]['sq']['current'], 'e1');
        $this->assertSame($rule[Piece::K][Castle::LONG]['sq']['next'], 'c1');
        $this->assertSame($rule[Piece::R][Castle::LONG]['sq']['current'], 'a1');
        $this->assertSame($rule[Piece::R][Castle::LONG]['sq']['next'], 'd1');
    }

    /**
     * @test
     */
    public function b_CASTLE_LONG()
    {
        $rule = King::$castlingRule[Color::B];

        $this->assertSame($rule[Piece::K][Castle::LONG]['sqs'], [ 'b8', 'c8', 'd8' ]);
        $this->assertSame($rule[Piece::K][Castle::LONG]['sq']['current'], 'e8');
        $this->assertSame($rule[Piece::K][Castle::LONG]['sq']['next'], 'c8');
        $this->assertSame($rule[Piece::R][Castle::LONG]['sq']['current'], 'a8');
        $this->assertSame($rule[Piece::R][Castle::LONG]['sq']['next'], 'd8');
    }

    /**
     * @test
     */
    public function w_CASTLE_SHORT()
    {
        $rule = King::$castlingRule[Color::W];

        $this->assertSame($rule[Piece::K][Castle::SHORT]['sqs'], [ 'f1', 'g1' ]);
        $this->assertSame($rule[Piece::K][Castle::SHORT]['sq']['current'], 'e1');
        $this->assertSame($rule[Piece::K][Castle::SHORT]['sq']['next'], 'g1');
        $this->assertSame($rule[Piece::R][Castle::SHORT]['sq']['current'], 'h1');
        $this->assertSame($rule[Piece::R][Castle::SHORT]['sq']['next'], 'f1');
    }

    /**
     * @test
     */
    public function b_CASTLE_SHORT()
    {
        $rule = King::$castlingRule[Color::B];

        $this->assertSame($rule[Piece::K][Castle::SHORT]['sqs'], [ 'f8', 'g8' ]);
        $this->assertSame($rule[Piece::K][Castle::SHORT]['sq']['current'], 'e8');
        $this->assertSame($rule[Piece::K][Castle::SHORT]['sq']['next'], 'g8');
        $this->assertSame($rule[Piece::R][Castle::SHORT]['sq']['current'], 'h8');
        $this->assertSame($rule[Piece::R][Castle::SHORT]['sq']['next'], 'f8');
    }

    /**
     * @test
     */
    public function mobility_a2()
    {
        $king = new King('w', 'a2');
        $mobility = (object) [
            'up' => 'a3',
            'down' => 'a1',
            'right' => 'b2',
            'upRight' => 'b3',
            'downRight' => 'b1'
        ];
        $this->assertEquals($mobility, $king->getMobility());
    }

    /**
     * @test
     */
    public function mobility_d5()
    {
        $king = new King('w', 'd5');
        $mobility = (object) [
            'up' => 'd6',
            'down' => 'd4',
            'left' => 'c5',
            'right' => 'e5',
            'upLeft' => 'c6',
            'upRight' => 'e6',
            'downLeft' => 'c4',
            'downRight' => 'e4'
        ];
        $this->assertEquals($mobility, $king->getMobility());
    }

    /**
     * @test
     */
    public function get_sqs_benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $king = $board->getPieceBySq('f1');

        $expected = [ 'e1', 'e2', 'g2' ];

        $this->assertSame($expected, $king->sqs());
    }
}
