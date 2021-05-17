<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\TacticsEvaluation;
use Chess\Tests\AbstractUnitTestCase;

class TacticsEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_d5()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'd5'));

        $tacticsEvald = (new TacticsEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => ['e4'],
        ];

        $this->assertEquals($expected, $tacticsEvald);
    }

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

        $tacticsEvald = (new TacticsEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => [],
            Symbol::BLACK => ['b5', 'e5'],
        ];

        $this->assertEquals($expected, $tacticsEvald);
    }
}
