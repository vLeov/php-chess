<?php

namespace PGNChess\Tests\Unit\Event;

use PGNChess\Board;
use PGNChess\Event\PawnThreateningMinorPiece as PawnThreateningMinorPieceEvent;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class PawnThreateningMinorPieceTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function d4_e4()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd5'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'g3'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'e4'));
        $this->assertEquals(1, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Bg2'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd4'));
        $this->assertEquals(1, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'O-O'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd3'));
        $this->assertEquals(0, (new PawnThreateningMinorPieceEvent($board))->capture(Symbol::BLACK));
    }
}
