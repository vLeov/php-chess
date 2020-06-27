<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Opening\Sicilian\Closed as ClosedSicilian;
use PGNChess\Opening\Sicilian\Open as OpenSicilian;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Space as SpaceEvaluation;
use PGNChess\Tests\AbstractUnitTestCase;

class SpaceTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $spEvald = (new SpaceEvaluation(new Board))->evaluate(SpaceEvaluation::FEATURE_SPACE);

        $expected = [
            Symbol::WHITE => [
                'a3', 'b3', 'c3', 'd3', 'e3', 'f3', 'g3', 'h3',
            ],
            Symbol::BLACK => [
                'a6', 'b6', 'c6', 'd6', 'e6', 'f6', 'g6', 'h6',
            ],
        ];

        $this->assertEquals($expected, $spEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $spEvald = (new SpaceEvaluation($board))->evaluate(SpaceEvaluation::FEATURE_SPACE);

        $expected = [
            Symbol::WHITE => [
                'a3', 'a4', 'a6', 'b1', 'b3', 'b5', 'c4', 'c6',
                'd2', 'd3', 'd5', 'e2', 'e3', 'e6', 'f3', 'f4',
                'f5', 'g1', 'g3', 'g4', 'g5', 'h3', 'h5', 'h6',
            ],
            Symbol::BLACK => [
                'a5', 'a6', 'b6', 'c5', 'c6', 'c7', 'd5', 'd7',
                'e5', 'e6', 'f5', 'g4', 'g6', 'g8', 'h3', 'h5',
                'h6',
            ],
        ];

        $this->assertEquals($expected, $spEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $spEvald = (new SpaceEvaluation($board))->evaluate(SpaceEvaluation::FEATURE_SPACE);

        $expected = [
            Symbol::WHITE => [
                'a3', 'a4', 'b1', 'b3', 'b5', 'c4', 'd2', 'd5',
                'e2', 'e3', 'f1', 'f3', 'f4', 'f5', 'g4', 'g5',
                'h3', 'h4', 'h5', 'h6',
            ],
            Symbol::BLACK => [
                'a5', 'a6', 'b4', 'b6', 'b8', 'c7', 'd4', 'd7',
                'e5', 'e6', 'f5', 'f6', 'f8', 'g4', 'h3', 'h5',
                'h6',
            ],
        ];

        $this->assertEquals($expected, $spEvald);
    }
}
