<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\GuardEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class GuardEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $guardEvald = (new GuardEvaluation(new Board()))->evaluate();

        $expected = [
            Symbol::WHITE => 32,
            Symbol::BLACK => 32,
        ];

        $this->assertEquals($expected, $guardEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $guardEvald = (new GuardEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 32,
            Symbol::BLACK => 32,
        ];

        $this->assertEquals($expected, $guardEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $guardEvald = (new GuardEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 32,
            Symbol::BLACK => 32,
        ];

        $this->assertEquals($expected, $guardEvald);
    }
}
