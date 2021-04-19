<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;
use Chess\Evaluation\KingSafety as KingSafetyEvaluation;
use Chess\Evaluation\Value\System;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class KingSafetyTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $kSafetyEvald = (new KingSafetyEvaluation(new Board))->evaluate(System::SYSTEM_BERLINER);

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 1,
        ];

        $this->assertEquals($expected, $kSafetyEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $kSafetyEvald = (new KingSafetyEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 1,
        ];

        $this->assertEquals($expected, $kSafetyEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $kSafetyEvald = (new KingSafetyEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 1,
        ];

        $this->assertEquals($expected, $kSafetyEvald);
    }
}
