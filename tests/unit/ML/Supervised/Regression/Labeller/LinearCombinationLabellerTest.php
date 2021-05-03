<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\LinearCombinationLabeller;
use Chess\ML\Supervised\Regression\Sampler;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class LinearCombinationLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $sample = (new Sampler(new Board))->sample();

        $expected = [
            Symbol::WHITE => 2900,
            Symbol::BLACK => 2900,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 2900,
            Symbol::BLACK => 2900,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 3250,
            Symbol::BLACK => 2550,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 2450,
            Symbol::BLACK => 3350,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();
        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 710,
            Symbol::BLACK => 5300,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();
        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 3949,
            Symbol::BLACK => 2405,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();
        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 3548,
            Symbol::BLACK => 2136,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();
        $sample = (new Sampler($board))->sample();

        $expected = [
            Symbol::WHITE => 2755,
            Symbol::BLACK => 1810,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample))->label());
    }
}
