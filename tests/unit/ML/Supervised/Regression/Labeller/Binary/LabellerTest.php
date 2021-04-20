<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller\Binary;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\Binary\Labeller as BinaryLabeller;
use Chess\ML\Supervised\Regression\Sampler\BinarySampler;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class LabellerTest extends AbstractUnitTestCase
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
            Symbol::WHITE => 11,
            Symbol::BLACK => 36,
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
            Symbol::WHITE => 2,
            Symbol::BLACK => 36,
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
            Symbol::WHITE => 4,
            Symbol::BLACK => 4155,
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
            Symbol::WHITE => 6323,
            Symbol::BLACK => 12,
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
            Symbol::WHITE => 186,
            Symbol::BLACK => 19,
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
            Symbol::WHITE => 138,
            Symbol::BLACK => 5,
        ];

        $this->assertEquals($expected, (new BinaryLabeller($sample))->label());
    }
}
