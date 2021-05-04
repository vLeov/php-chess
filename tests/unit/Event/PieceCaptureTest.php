<?php

namespace Chess\Tests\Unit\Event;

use Chess\Board;
use Chess\Event\PieceCapture as PieceCaptureEvent;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;

class PieceCaptureTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $this->assertEquals(0, (new PieceCaptureEvent($board))->capture(Symbol::WHITE));
        $this->assertEquals(0, (new PieceCaptureEvent($board))->capture(Symbol::BLACK));
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $this->assertEquals(1, (new PieceCaptureEvent($board))->capture(Symbol::WHITE));
        $this->assertEquals(0, (new PieceCaptureEvent($board))->capture(Symbol::BLACK));
    }

    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board()))->play();

        $this->assertEquals(0, (new PieceCaptureEvent($board))->capture(Symbol::WHITE));
        $this->assertEquals(0, (new PieceCaptureEvent($board))->capture(Symbol::BLACK));
    }
}
