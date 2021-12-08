<?php

namespace Chess\Tests\Unit\Board;

use Chess\Board;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\DefenseEvaluation;
use Chess\Tests\AbstractUnitTestCase;

class DefenseEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5_Nf3_Nc6_Bb5_a6_Nxe5()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Bb5'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'a6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nxe5'));

        $defenseEvald = (new DefenseEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [
                'a2', 'b1', 'b2', 'c1', 'c2', 'd1', 'd2', 'd2', 'd2', 'd2',
                'e1', 'e1', 'f2', 'h2',
            ],
            Symbol::BLACK => [
                'a6', 'a6', 'b7', 'c6', 'c6', 'c7', 'c8', 'c8', 'd7', 'd7',
                'd7', 'd8', 'd8', 'e8', 'f7', 'f8', 'g7', 'g8', 'h7',
            ],
        ];

        $this->assertSame($expected, $defenseEvald);
    }
}
