<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\Attack as AttackEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class AttackTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $pressEvald = (new AttackEvaluation(new Board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $pressEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $pressEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 1,
        ];

        $this->assertEquals($expected, $pressEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $pressEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 3.2,
        ];

        $this->assertEquals($expected, $pressEvald);
    }
}
