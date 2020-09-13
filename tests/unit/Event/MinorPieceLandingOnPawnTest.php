<?php

namespace PGNChess\Tests\Unit\Event;

use PGNChess\Board;
use PGNChess\Event\MinorPieceLandingOnPawn as MinorPieceLandingOnPawnEvent;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class MinorPieceLandingOnPawnTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->assertEquals(0, (new MinorPieceLandingOnPawnEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'd6'));
        $this->assertEquals(0, (new MinorPieceLandingOnPawnEvent($board))->capture(Symbol::WHITE));

        $board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $this->assertEquals(0, (new MinorPieceLandingOnPawnEvent($board))->capture(Symbol::BLACK));

        $board->play(Convert::toStdObj(Symbol::BLACK, 'Bf5'));
        $this->assertEquals(1, (new MinorPieceLandingOnPawnEvent($board))->capture(Symbol::WHITE));
    }
}
