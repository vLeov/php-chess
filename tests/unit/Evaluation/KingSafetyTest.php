<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Opening\Sicilian\Closed as ClosedSicilian;
use PGNChess\Opening\Sicilian\Open as OpenSicilian;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Tests\AbstractUnitTestCase;

class KingSafetyTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $kSafetyEvald = (new KingSafetyEvaluation(new Board))->evaluate();

        $expected = [
            Symbol::WHITE => 168,
            Symbol::BLACK => 168,
        ];

        $this->assertEquals($expected, $kSafetyEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $kSafetyEvald = (new KingSafetyEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 42,
            Symbol::BLACK => 84,
        ];

        $this->assertEquals($expected, $kSafetyEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $kSafetyEvald = (new KingSafetyEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 14,
            Symbol::BLACK => 28,
        ];

        $this->assertEquals($expected, $kSafetyEvald);
    }
}
