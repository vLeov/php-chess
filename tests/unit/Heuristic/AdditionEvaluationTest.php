<?php

namespace Chess\Tests\Unit\Heuristic;

use Chess\Board;
use Chess\Heuristic\AdditionEvaluation;
use Chess\Heuristic\Picture\Positional as PositionalHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class AdditionEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function evaluate_benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());

        $evaluation = (new AdditionEvaluation($heuristicPicture))->evaluate();

        $expected = [
            Symbol::WHITE => 3.94,
            Symbol::BLACK => 5.55,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
