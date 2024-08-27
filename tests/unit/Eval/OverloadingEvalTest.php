<?php

namespace Chess\Tests\unit\Eval;

use Chess\Eval\OverloadingEval;
use Chess\FenToBoardFactory;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class OverloadingEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function kaufman_09()
    {
        $expectedResult = [
            'w' => ['d2', 'e1'],
            'b' => ['b7', 'c7', 'c4'],
        ];

        $expectedExplanation = [
            "White has a slight overloading advantage.",
        ];

        $expectedElaboration = [
            "The bishop on b7 is overloaded defending more than one piece.",
            "The knight on c7 is overloaded defending more than one piece.",
            "Black's queen on c4 is overloaded defending more than one piece.",
            "White's queen on d2 is overloaded defending more than one piece.",
            "White's king on e1 is overloaded defending more than one piece.",
        ];

        $board = FenToBoardFactory::create('r3k2r/pbn2ppp/8/1P1pP3/P1qP4/5B2/3Q1PPP/R3K2R w KQkq -');

        $overloadingEval = new OverloadingEval($board);

        $this->assertSame($expectedResult, $overloadingEval->getResult());
        $this->assertSame($expectedExplanation, $overloadingEval->getExplanation());
        $this->assertSame($expectedElaboration, $overloadingEval->getElaboration());
    }
}
