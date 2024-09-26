<?php

namespace Chess\Tests\Unit\Eval;

use Chess\FenToBoardFactory;
use Chess\Eval\BackRankCheckmateEval;
use Chess\Tests\AbstractUnitTestCase;

class BackRankCheckmateEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function b8_checkmate()
    {
        $expectedResult = [
            'w' => 1,
            'b' => 0,
        ];

        $expectedExplanation = [
            "White has a back-rank checkmate advantage.",
        ];

        $expectedElaboration = [
            "One of the pawns in front of Black's king on g8 should be moved as long as there is a need to be guarded against back-rank threats.",
        ];

        $board = FenToBoardFactory::create('6k1/R4ppp/4p3/1r6/6P1/3R1P2/4P1P1/4K3 b KQkq -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }

    /**
     * @test
     */
    public function d1_checkmate()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 1,
        ];

        $expectedExplanation = [
            "Black has a back-rank checkmate advantage.",
        ];

        $expectedElaboration = [
            "One of the pawns in front of White's king on g1 should be moved as long as there is a need to be guarded against back-rank threats.",
        ];

        $board = FenToBoardFactory::create('3r4/k7/8/8/8/8/5PPP/6K1 w - -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }

    /**
     * @test
     */
    public function h8_checkmate()
    {
        $expectedResult = [
            'w' => 1,
            'b' => 0,
        ];

        $expectedExplanation = [
            "White has a back-rank checkmate advantage.",
        ];

        $expectedElaboration = [
            "One of the pawns in front of Black's king on e8 should be moved as long as there is a need to be guarded against back-rank threats.",
        ];

        $board = FenToBoardFactory::create('4k3/3ppp2/8/8/8/8/6K1/7R b - -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }

    /**
     * @test
     */
    public function d1_and_h8_checkmates()
    {
        $expectedResult = [
            'w' => 1,
            'b' => 1,
        ];

        $expectedExplanation = [
        ];

        $expectedElaboration = [
            "One of the pawns in front of Black's king on e8 should be moved as long as there is a need to be guarded against back-rank threats.",
            "One of the pawns in front of White's king on b1 should be moved as long as there is a need to be guarded against back-rank threats.",
        ];

        $board = FenToBoardFactory::create('4k3/3ppp2/8/8/6q1/8/PPP4R/1K6 w - -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }

    /**
     * @test
     */
    public function no_checkmate()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 0,
        ];

        $expectedExplanation = [
        ];

        $expectedElaboration = [
        ];

        $board = FenToBoardFactory::create('4k3/3ppp2/8/8/8/8/6K1/7N b - -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }

    /**
     * @test
     */
    public function A40()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 0,
        ];

        $expectedExplanation = [
        ];

        $expectedElaboration = [
        ];

        $board = FenToBoardFactory::create('rnbqk2r/ppppppbp/5np1/8/2PP4/5N2/PP2PPPP/RNBQKB1R w KQkq -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }

    /**
     * @test
     */
    public function e4()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 0,
        ];

        $expectedExplanation = [
        ];

        $expectedElaboration = [
        ];

        $board = FenToBoardFactory::create('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -');
        $backRankEval = new BackRankCheckmateEval($board);

        $this->assertSame($expectedResult, $backRankEval->getResult());
        $this->assertSame($expectedExplanation, $backRankEval->getExplanation());
        $this->assertSame($expectedElaboration, $backRankEval->getElaboration());
    }
}
