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
        $attdEvald = (new AttackedEvaluation(new Board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $attdEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $attdEvald = (new AttackedEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $attdEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $attdEvald = (new AttackedEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 3.2,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $attdEvald);
    }
}
