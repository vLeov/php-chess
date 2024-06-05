<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Eval\CheckmateInPlyEval;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\FEN\StrToBoard;

class CheckmateInPlyEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function fool_chechmate()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 1,
        ];

        $expectedExplanation = [
            "Black could checkmate in half a move.",
        ];

        $expectedElaboration = [
            "Black threatens to play Qh4# delivering checkmate in half a move.",
        ];

        $board = (new StrToBoard('rnbqkbnr/pppp1ppp/8/4p3/6P1/5P2/PPPPP2P/RNBQKBNR b KQkq g3'))->create();
        $checkmateInOneEval = new CheckmateInPlyEval($board);

        $this->assertSame($expectedResult, $checkmateInOneEval->getResult());
        $this->assertSame($expectedExplanation, $checkmateInOneEval->getExplanation());
        $this->assertSame($expectedElaboration, $checkmateInOneEval->getElaboration());
    }

    /**
     * @test
     */
    public function fool_chechmate_a6()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 0,
        ];

        $expectedExplanation = [];

        $expectedElaboration = [];

        $board = (new StrToBoard('rnbqkbnr/1ppp1ppp/p7/4p3/6P1/5P2/PPPPP2P/RNBQKBNR w KQkq -'))->create();
        $checkmateInOneEval = new CheckmateInPlyEval($board);

        $this->assertSame($expectedResult, $checkmateInOneEval->getResult());
        $this->assertSame($expectedExplanation, $checkmateInOneEval->getExplanation());
        $this->assertSame($expectedElaboration, $checkmateInOneEval->getElaboration());
    }
}
