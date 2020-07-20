<?php

namespace PGNChess\Tests\Unit;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\PGN\Symbol;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Type\RookType;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\RuyLopez\Open as OpenRuyLopez;

class CastlingTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function white_long()
    {
        $rule = CastlingRule::color(Symbol::WHITE);

        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['squares']['b'], 'b1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['squares']['c'], 'c1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['squares']['d'], 'd1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['position']['current'], 'e1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['position']['next'], 'c1');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_LONG]['position']['current'], 'a1');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_LONG]['position']['next'], 'd1');
    }

    /**
     * @test
     */
    public function black_long()
    {
        $rule = CastlingRule::color(Symbol::BLACK);

        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['squares']['b'], 'b8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['squares']['c'], 'c8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['squares']['d'], 'd8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['position']['current'], 'e8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_LONG]['position']['next'], 'c8');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_LONG]['position']['current'], 'a8');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_LONG]['position']['next'], 'd8');
    }

    /**
     * @test
     */
    public function white_short()
    {
        $rule = CastlingRule::color(Symbol::WHITE);

        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['squares']['f'], 'f1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['squares']['g'], 'g1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['position']['current'], 'e1');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['position']['next'], 'g1');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_SHORT]['position']['current'], 'h1');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_SHORT]['position']['next'], 'f1');
    }

    /**
     * @test
     */
    public function black_short()
    {
        $rule = CastlingRule::color(Symbol::BLACK);

        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['squares']['f'], 'f8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['squares']['g'], 'g8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['position']['current'], 'e8');
        $this->assertEquals($rule[Symbol::KING][Symbol::CASTLING_SHORT]['position']['next'], 'g8');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_SHORT]['position']['current'], 'h8');
        $this->assertEquals($rule[Symbol::ROOK][Symbol::CASTLING_SHORT]['position']['next'], 'f8');
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function invalid_white_short()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => false
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function invalid_white_long()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => true
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function invalid_black_short()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function invalid_black_long()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => true
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function empty()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $board = new Board($pieces);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function empty_white()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => true
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function empty_black()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function no_castled_property()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function no_castling_short_property()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_LONG => false
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\CastlingException
     */
    public function no_castling_long_property()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);
    }

    /**
     * @test
     */
    public function open_ruy_lopez()
    {
        $board = (new OpenRuyLopez(new Board))->play();

        $expected = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false,
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => false,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => true,
            ],
        ];

        $this->assertEquals($expected, $board->getCastling());
    }
}
