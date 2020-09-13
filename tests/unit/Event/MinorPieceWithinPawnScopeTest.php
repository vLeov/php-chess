<?php

namespace PGNChess\Tests\Unit\Event;

use PGNChess\Board;
use PGNChess\Event\MinorPieceWithinPawnScope as MinorPieceWithinPawnScopeEvent;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class MinorPieceWithinPawnScopeTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->assertEquals(0, (new MinorPieceWithinPawnScopeEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd6'));
        $this->assertEquals(0, (new MinorPieceWithinPawnScopeEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $this->assertEquals(0, (new MinorPieceWithinPawnScopeEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'Bf5'));
        $this->assertEquals(1, (new MinorPieceWithinPawnScopeEvent($board))->capture(Symbol::WHITE));
    }
}
