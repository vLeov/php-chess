<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\PrimesLabeller;
use Chess\ML\Supervised\Regression\Sampler\PrimesSampler;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class PrimesLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $sample = (new PrimesSampler(new Board))->sample();

        $expected = [
            Symbol::WHITE => 2050,
            Symbol::BLACK => 2050,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 2050,
            Symbol::BLACK => 2050,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 1750,
            Symbol::BLACK => 2350,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6()
    {
        $board = new Board;
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 1300,
            Symbol::BLACK => 2800,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();
        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 510,
            Symbol::BLACK => 3600,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();
        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 2875,
            Symbol::BLACK => 1365,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();
        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 2472,
            Symbol::BLACK => 1641,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();
        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 1395,
            Symbol::BLACK => 1034,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }
}
