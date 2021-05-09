<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\PressureEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class PressureEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $pressEvald = (new PressureEvaluation(new Board()))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];

        $this->assertEquals($expected, $pressEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $pressEvald = (new PressureEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => ['e4'],
        ];

        $this->assertEquals($expected, $pressEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $pressEvald = (new PressureEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => ['c3'],
        ];

        $this->assertEquals($expected, $pressEvald);
    }
}
