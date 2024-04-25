<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Eval\ThreatEval;
use Chess\Variant\Classical\FEN\StrToBoard;
use Chess\Tests\AbstractUnitTestCase;

class ThreatEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function B21()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 0,
        ];

        $expectedPhrase = [];

        $board = (new StrToBoard('r1bqkbnr/5ppp/p1npp3/1p6/2B1P3/2N2N2/PP2QPPP/R1B2RK1 w kq b6'))->create();
        $threatEval = new ThreatEval($board);

        $this->assertSame($expectedResult, $threatEval->getResult());
        $this->assertSame($expectedPhrase, $threatEval->getElaboration());
    }

    /**
     * @test
     */
    public function middlegame()
    {
        $expectedResult = [
            'w' => 1,
            'b' => 0,
        ];

        $expectedPhrase = [
            "The knight on b5 is being threatened and may be lost if not defended properly.",
        ];

        $board = (new StrToBoard('r1bqkbnr/5ppp/p1npp3/1n6/2B1P3/2N2N2/PP2QPPP/R1B2RK1 w kq b6'))->create();
        $threatEval = new ThreatEval($board);

        $this->assertSame($expectedResult, $threatEval->getResult());
        $this->assertSame($expectedPhrase, $threatEval->getElaboration());
    }

    /**
     * @test
     */
    public function endgame()
    {
        $expectedResult = [
            'w' => 0,
            'b' => 1,
        ];

        $expectedPhrase = [
            "The pawn on d4 is being threatened and may be lost if not defended properly.",
        ];

        $board = (new StrToBoard('6k1/6p1/2n2b2/8/3P4/5N2/2K5/8 w - -'))->create();
        $threatEval = new ThreatEval($board);

        $this->assertSame($expectedResult, $threatEval->getResult());
        $this->assertSame($expectedPhrase, $threatEval->getElaboration());
    }
}
