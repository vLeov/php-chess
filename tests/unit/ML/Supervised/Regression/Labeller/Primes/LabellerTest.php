<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Labeller\Primes;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\Primes\Labeller as PrimesLabeller;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class LabellerTest extends AbstractUnitTestCase
{
    // Possible moves after w e4

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $expected = [
            Symbol::WHITE => 558.66,
            Symbol::BLACK => 558.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $expected = [
            Symbol::WHITE => 556.66,
            Symbol::BLACK => 571.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_Nf6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));

        $expected = [
            Symbol::WHITE => 556.66,
            Symbol::BLACK => 571.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_Nh6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nh6'));

        $expected = [
            Symbol::WHITE => 556.66,
            Symbol::BLACK => 558.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_a6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'a6'));

        $expected = [
            Symbol::WHITE => 558.66,
            Symbol::BLACK => 567.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_a5()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'a5'));

        $expected = [
            Symbol::WHITE => 556.66,
            Symbol::BLACK => 561.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_b6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'b6'));

        $expected = [
            Symbol::WHITE => 556.66,
            Symbol::BLACK => 564.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_b5()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'b5'));

        $expected = [
            Symbol::WHITE => 558.66,
            Symbol::BLACK => 555.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function w_e4_b_c6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'c6'));

        $expected = [
            Symbol::WHITE => 556.66,
            Symbol::BLACK => 569.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $expected = [
            Symbol::WHITE => 549.66,
            Symbol::BLACK => 556.66,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($board))->calc());
    }
}
