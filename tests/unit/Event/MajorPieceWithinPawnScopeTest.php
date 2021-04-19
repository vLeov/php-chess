<?php

namespace Chess\Tests\Unit\Event;

use Chess\Board;
use Chess\Event\MajorPieceWithinPawnScope as MajorPieceWithinPawnScopeEvent;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;

class MajorPieceWithinPawnScopeTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function Qg5()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->assertEquals(0, (new MajorPieceWithinPawnScopeEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->assertEquals(0, (new MajorPieceWithinPawnScopeEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'f4'));
        $this->assertEquals(0, (new MajorPieceWithinPawnScopeEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'Qg5'));
        $this->assertEquals(1, (new MajorPieceWithinPawnScopeEvent($board))->capture(Symbol::WHITE));
    }
}
