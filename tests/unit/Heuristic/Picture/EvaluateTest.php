<?php

namespace Chess\Tests\Unit\Heuristic\Picture;

use Chess\Board;
use Chess\Heuristic\HeuristicPicture;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class EvaluateTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function evaluate_benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());

        $evaluation = $heuristicPicture->evaluate();

        $expected = [
            Symbol::WHITE => 46.3,
            Symbol::BLACK => 28,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
