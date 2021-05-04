<?php

namespace Chess\Tests\Unit\Heuristic;

use Chess\Board;
use Chess\Heuristic\LinearCombinationEvaluation;
use Chess\Heuristic\Picture\Standard as StandardHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class LinearCombinationEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function evaluate_benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());

        $evaluation = (new LinearCombinationEvaluation($heuristicPicture))->evaluate();

        $expected = [
            Symbol::WHITE => 35.48,
            Symbol::BLACK => 21.36,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
