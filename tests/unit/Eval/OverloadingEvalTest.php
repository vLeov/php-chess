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
    public function f7_pawn()
    {
        $expectedResult = [
            'w' => [],
            'b' => ['f7'],
        ];

        $expectedExplanation = [
            "White has a slight overloading advantage.",
        ];

        $expectedElaboration = [
            "The pawn on f7 is overloaded defending more than one piece at the same time.",
        ];

        $board = FenToBoardFactory::create('6k1/5pp1/4b1n1/8/8/3BR3/5PPP/6K1 w - -');

        $overloadingEval = new OverloadingEval($board);

        $this->assertSame($expectedResult, $overloadingEval->getResult());
        $this->assertSame($expectedExplanation, $overloadingEval->getExplanation());
        $this->assertSame($expectedElaboration, $overloadingEval->getElaboration());
    }
}
