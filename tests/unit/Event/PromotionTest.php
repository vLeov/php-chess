<?php

namespace PGNChess\Tests\Unit\Event;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\Event\Promotion as PromotionEvent;
use PGNChess\Piece\King;
use PGNChess\Piece\Pawn;
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
}
