<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\Pressured as PressuredEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class PressuredTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $pressEvald = (new PressuredEvaluation(new Board))->evaluate();

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
        $board = (new OpenSicilian(new Board))->play();

        $pressEvald = (new PressuredEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => ['e4'],
            Symbol::BLACK => [],
        ];

        $this->assertEquals($expected, $pressEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $pressEvald = (new PressuredEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => ['c3'],
            Symbol::BLACK => [],
        ];

        $this->assertEquals($expected, $pressEvald);
    }
}
