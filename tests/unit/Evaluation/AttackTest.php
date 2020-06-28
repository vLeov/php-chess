<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Opening\Sicilian\Closed as ClosedSicilian;
use PGNChess\Opening\Sicilian\Open as OpenSicilian;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Tests\AbstractUnitTestCase;

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
