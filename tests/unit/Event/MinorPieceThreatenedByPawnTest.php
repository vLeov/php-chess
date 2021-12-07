<?php

namespace Chess\Tests\Unit\Event;

use Chess\Board;
use Chess\Event\MinorPieceThreatenedByPawn as MinorPieceThreatenedByPawnEvent;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;

class MinorPieceThreatenedByPawnTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function d4_e4()
    {
        $board = new Board();

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd5'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'g3'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'e4'));
        $this->assertSame(1, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Bg2'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd4'));
        $this->assertSame(1, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'O-O'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd3'));
        $this->assertSame(0, (new MinorPieceThreatenedByPawnEvent($board))->capture(Symbol::BLACK));
    }
}
