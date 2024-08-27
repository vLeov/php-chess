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
            'w' => ['d2', 'a1', 'e1', 'h1'],
            'b' => ['a8', 'h8', 'b7', 'c7', 'c4'],
        ];

        $expectedExplanation = [
            "Black has a slight overloading advantage.",
        ];

        $expectedElaboration = [
            "a7 and d5 are isolated pawns.",
        ];

        $board = FenToBoardFactory::create('r3k2r/pbn2ppp/8/1P1pP3/P1qP4/5B2/3Q1PPP/R3K2R w KQkq -');

        $overloadingEval = new OverloadingEval($board);

        $this->assertSame($expectedResult, $overloadingEval->getResult());
        $this->assertSame($expectedExplanation, $overloadingEval->getExplanation());
    }
}
