<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\Ease as EaseEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class EaseTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $easeEvald = (new EaseEvaluation(new Board()))->evaluate();

        $expected = [
            Symbol::WHITE => 16,
            Symbol::BLACK => 16,
        ];

        $this->assertEquals($expected, $easeEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $easeEvald = (new EaseEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 15,
            Symbol::BLACK => 16,
        ];

        $this->assertEquals($expected, $easeEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $easeEvald = (new EaseEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 15,
            Symbol::BLACK => 16,
        ];

        $this->assertEquals($expected, $easeEvald);
    }
}
