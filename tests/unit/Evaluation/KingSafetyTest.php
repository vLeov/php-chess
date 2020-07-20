<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Value\System;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Unit\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use PGNChess\Tests\Unit\Sample\Opening\Sicilian\Open as OpenSicilian;

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
