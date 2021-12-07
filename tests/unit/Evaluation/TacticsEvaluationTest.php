<?php

namespace Chess\Tests\Unit\Evaluation;

use Chess\Board;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Evaluation\TacticsEvaluation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class TacticsEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $attEvald = (new TacticsEvaluation(new Board()))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertSame($expected, $attEvald);
    }

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
            Symbol::WHITE => 0,
            Symbol::BLACK => 1,
        ];

        $this->assertSame($expected, $tacticsEvald);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $attEvald = (new TacticsEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertSame($expected, $attEvald);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $attEvald = (new TacticsEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertSame($expected, $attEvald);
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
            Symbol::WHITE => 0,
            Symbol::BLACK => 6.53,
        ];

        $this->assertSame($expected, $tacticsEvald);
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_Nf6_a3_Nxe4_d3()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'a3'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nxe4'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'd3'));

        $tacticsEvald = (new TacticsEvaluation($board))->evaluate();

        $expected = [
            Symbol::WHITE => 4.2,
            Symbol::BLACK => 0,
        ];

        $this->assertSame($expected, $tacticsEvald);
    }
}
