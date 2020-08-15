<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Evaluation\Capture as CaptureEvaluation;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use PGNChess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use PGNChess\Tests\Sample\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;

class CaptureTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $captureEvald = (new CaptureEvaluation($board))->evaluate();

        $this->assertEquals($expected, $captureEvald);
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 0,
        ];

        $captureEvald = (new CaptureEvaluation($board))->evaluate();

        $this->assertEquals($expected, $captureEvald);
    }

    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board))->play();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $captureEvald = (new CaptureEvaluation($board))->evaluate();

        $this->assertEquals($expected, $captureEvald);
    }
}
