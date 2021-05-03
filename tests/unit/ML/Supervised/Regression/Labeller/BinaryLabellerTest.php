<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\BinaryLabeller;
use Chess\ML\Supervised\Regression\Sampler\BinarySampler;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class BinaryLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $sample = (new BinarySampler(new Board))->sample();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 204,
            Symbol::BLACK => 275,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 128,
            Symbol::BLACK => 272,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();
        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 19,
            Symbol::BLACK => 8684,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();
        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 12717,
            Symbol::BLACK => 91,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();
        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 227,
            Symbol::BLACK => 172,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();
        $sample = (new BinarySampler($board))->sample();

        $expected = [
            Symbol::WHITE => 211,
            Symbol::BLACK => 28,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }
}
