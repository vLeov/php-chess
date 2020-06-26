<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Square as SquareEvaluation;
use PGNChess\Tests\AbstractUnitTestCase;

class ControlTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board;

        $control = (new SquareEvaluation($board))->control();

        $expected = (object) [
            SquareEvaluation::TYPE_SPACE => (object) [
                Symbol::WHITE => [
                    'a3', 'b3', 'c3', 'd3', 'e3', 'f3', 'g3', 'h3',
                ],
                Symbol::BLACK => [
                    'a6', 'b6', 'c6', 'd6', 'e6', 'f6', 'g6', 'h6',
                ],
            ],
            SquareEvaluation::TYPE_ATTACK => (object) [
                Symbol::WHITE => [],
                Symbol::BLACK => [],
            ],
        ];

        $this->assertEquals($expected, $control);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'c5'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'd6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'cxd4'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nxd4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));

        $control = (new SquareEvaluation($board))->control();

        $expected = (object) [
            SquareEvaluation::TYPE_SPACE => (object) [
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
            ],
            SquareEvaluation::TYPE_ATTACK => (object) [
                Symbol::WHITE => [],
                Symbol::BLACK => [
                    'e4',
                ],
            ],
        ];

        $this->assertEquals($expected, $control);
    }
}
