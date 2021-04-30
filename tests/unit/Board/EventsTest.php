<?php

namespace Chess\Tests\Unit\Board;

use Chess\Board;
use Chess\Event\Check as CheckEvent;
use Chess\Event\MajorPieceThreatenedByPawn as MajorPieceThreatenedByPawnEvent;
use Chess\Event\MinorPieceThreatenedByPawn as MinorPieceThreatenedByPawnEvent;
use Chess\Event\PieceCapture as PieceCaptureEvent;
use Chess\Event\Promotion as PromotionEvent;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class EventsTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();

        $expected = (object) [
            Symbol::WHITE => [
                CheckEvent::DESC => 0,
                PieceCaptureEvent::DESC => 0,
                MajorPieceThreatenedByPawnEvent::DESC => 0,
                MinorPieceThreatenedByPawnEvent::DESC => 0,
                PromotionEvent::DESC => 0,
            ],
            Symbol::BLACK => [
                CheckEvent::DESC => 1,
                PieceCaptureEvent::DESC => 0,
                MajorPieceThreatenedByPawnEvent::DESC => 0,
                MinorPieceThreatenedByPawnEvent::DESC => 0,
                PromotionEvent::DESC => 0,
            ],
        ];

        $this->assertEquals($expected, $board->events());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();

        $expected = (object) [
            Symbol::WHITE => [
                CheckEvent::DESC => 1,
                PieceCaptureEvent::DESC => 1,
                MajorPieceThreatenedByPawnEvent::DESC => 0,
                MinorPieceThreatenedByPawnEvent::DESC => 0,
                PromotionEvent::DESC => 0,
            ],
            Symbol::BLACK => [
                CheckEvent::DESC => 0,
                PieceCaptureEvent::DESC => 0,
                MajorPieceThreatenedByPawnEvent::DESC => 0,
                MinorPieceThreatenedByPawnEvent::DESC => 0,
                PromotionEvent::DESC => 0,
            ],
        ];

        $this->assertEquals($expected, $board->events());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();

        $expected = (object) [
            Symbol::WHITE => [
                CheckEvent::DESC => 0,
                PieceCaptureEvent::DESC => 0,
                MajorPieceThreatenedByPawnEvent::DESC => 0,
                MinorPieceThreatenedByPawnEvent::DESC => 0,
                PromotionEvent::DESC => 0,
            ],
            Symbol::BLACK => [
                CheckEvent::DESC => 0,
                PieceCaptureEvent::DESC => 0,
                MajorPieceThreatenedByPawnEvent::DESC => 0,
                MinorPieceThreatenedByPawnEvent::DESC => 0,
                PromotionEvent::DESC => 0,
            ],
        ];

        $this->assertEquals($expected, $board->events());
    }
}
