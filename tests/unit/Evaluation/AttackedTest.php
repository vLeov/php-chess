<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\Attacked as AttackedEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class AttackedTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $attEvald = (new AttackedEvaluation(new Board))->evaluate();

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

        $attEvald = (new AttackedEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => ['e4'],
            Symbol::BLACK => [],
        ];

        $this->assertEquals($expected, $attEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $attEvald = (new AttackedEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => ['c3'],
            Symbol::BLACK => [],
        ];

        $this->assertEquals($expected, $attEvald);
    }
}
