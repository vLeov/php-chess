<?php

namespace PGNChess\Tests\Unit\Event;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\Event\Promotion as PromotionEvent;
use PGNChess\Piece\King;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Type\RookType;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class PromotionTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function b8_b1()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'b6'),
            new King(Symbol::WHITE, 'g5'),
            new Pawn(Symbol::BLACK, 'b3'),
            new King(Symbol::BLACK, 'd5'),
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

        $board = new Board($pieces, $castling);

        $board->play(Convert::toStdObj(Symbol::WHITE, 'b7'));
        $this->assertEquals(0, (new PromotionEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'b2'));
        $this->assertEquals(0, (new PromotionEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'b8'));
        $this->assertEquals(1, (new PromotionEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'b1'));
        $this->assertEquals(1, (new PromotionEvent($board))->capture(Symbol::BLACK));
    }

    /**
     * @test
     */
    public function bxa8_gxh1()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'b6'),
            new King(Symbol::WHITE, 'd3'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'g3'),
            new King(Symbol::BLACK, 'e6'),
            new Rook(Symbol::BLACK, 'a8', RookType::CASTLING_LONG),
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

        $board = new Board($pieces, $castling);

        $board->play(Convert::toStdObj(Symbol::WHITE, 'b7'));
        $this->assertEquals(0, (new PromotionEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'g2'));
        $this->assertEquals(0, (new PromotionEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'bxa8'));
        $this->assertEquals(1, (new PromotionEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'gxh1'));
        $this->assertEquals(1, (new PromotionEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Qxh1'));
        $this->assertEquals(0, (new PromotionEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'Ke5'));
        $this->assertEquals(0, (new PromotionEvent($board))->capture(Symbol::BLACK));
    }
}
