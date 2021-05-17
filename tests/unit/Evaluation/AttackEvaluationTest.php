<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\AttackEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class AttackEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $attEvald = (new AttackEvaluation(new Board()))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $attEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $attEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $attEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $attEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, $attEvald);
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

        $tacticsEvald = (new AttackEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 6.53,
        ];

        $this->assertEquals($expected, $tacticsEvald);
    }
}
