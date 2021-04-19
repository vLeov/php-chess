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
        $attEvald = (new AttackEvaluation(new Board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];

        $this->assertEquals($expected, $attEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $attEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => ['e4'],
        ];

        $this->assertEquals($expected, $attEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $attEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => ['c3'],
        ];

        $this->assertEquals($expected, $attEvald);
    }
}
