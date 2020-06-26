<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Opening\Sicilian\Closed as ClosedSicilian;
use PGNChess\Opening\Sicilian\Open as OpenSicilian;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Square as SquareEvaluation;
use PGNChess\Tests\AbstractUnitTestCase;

class EvaluateTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 8,
            ],
            Symbol::BLACK => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 8,
            ],
        ];

        $control = (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_CONTROL);

        $this->assertEquals($expected, $control);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $expected = [
            Symbol::WHITE => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 24,
            ],
            Symbol::BLACK => [
                SquareEvaluation::TYPE_ATTACK => 1,
                SquareEvaluation::TYPE_SPACE => 17,
            ],
        ];

        $board = (new OpenSicilian(new Board))->play();
        $control = (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_CONTROL);

        $this->assertEquals($expected, $control);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $expected = [
            Symbol::WHITE => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 20,
            ],
            Symbol::BLACK => [
                SquareEvaluation::TYPE_ATTACK => 1,
                SquareEvaluation::TYPE_SPACE => 17,
            ],
        ];

        $board = (new ClosedSicilian(new Board))->play();
        $control = (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_CONTROL);

        $this->assertEquals($expected, $control);
    }
}
