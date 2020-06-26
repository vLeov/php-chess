<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Piece\Bishop;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Queen;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Type\RookType;
use PGNChess\Evaluation\Square as SquareEvaluation;
use PGNChess\Tests\AbstractUnitTestCase;

class EvaluateTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 8,
            ],
            Symbol::BLACK => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 8,
            ],
        ];

        $control = (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_CONTROL);

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

        $control = (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_CONTROL);

        $expected = [
            Symbol::WHITE => [
                SquareEvaluation::TYPE_ATTACK => 0,
                SquareEvaluation::TYPE_SPACE => 24,
            ],
            Symbol::BLACK => [
                SquareEvaluation::TYPE_ATTACK => 1,
                SquareEvaluation::TYPE_SPACE => 17,
            ],
        ];

        $control = (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_CONTROL);

        $this->assertEquals($expected, $control);
    }
}
