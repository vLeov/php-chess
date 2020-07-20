<?php

namespace PGNChess\Tests\Unit\Board;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Type\RookType;
use PGNChess\Tests\AbstractUnitTestCase;

class InvalidMovesTest extends AbstractUnitTestCase
{
    /**
     * @test
     * @expectedException \PGNChess\Exception\UnknownNotationException
     */
    public function numeric_value()
    {
        (new Board)->play(Convert::toStdObj(Symbol::WHITE, 9));
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\UnknownNotationException
     */
    public function foo()
    {
        (new Board)->play(Convert::toStdObj(Symbol::WHITE, 'foo'));
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\UnknownNotationException
     */
    public function bar()
    {
        (new Board)->play(Convert::toStdObj(Symbol::WHITE, 'bar'));
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\UnknownNotationException
     */
    public function e9()
    {
        (new Board)->play(Convert::toStdObj(Symbol::WHITE, 'e9'));
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\UnknownNotationException
     */
    public function e10()
    {
        (new Board)->play(Convert::toStdObj(Symbol::WHITE, 'e10'));
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\UnknownNotationException
     */
    public function Nw3()
    {
        (new Board)->play(Convert::toStdObj(Symbol::WHITE, 'Nw3'));
    }

    /**
     * @test
     * @expectedException \PGNChess\Exception\BoardException
     */
    public function piece_does_not_exist()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'g3'),
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
                Symbol::CASTLING_LONG => false
            ]
        ];

        (new Board($pieces, $castling))
            ->play(Convert::toStdObj(Symbol::WHITE, 'f4'));
    }
}
