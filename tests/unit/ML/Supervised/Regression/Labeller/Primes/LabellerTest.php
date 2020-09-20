<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Labeller\Primes;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\Primes\Labeller as PrimesLabeller;
use PGNChess\ML\Supervised\Regression\Sampler\Primes\Sampler as PrimesSampler;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use PGNChess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use PGNChess\Tests\Sample\Opening\Benoni\BenkoGambit;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class LabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $sample = (new PrimesSampler(new Board))->sample();

        $expected = [
            Symbol::WHITE => 106200,
            Symbol::BLACK => 106200,
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
            Symbol::WHITE => 106200,
            Symbol::BLACK => 106200,
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
            Symbol::WHITE => 96450,
            Symbol::BLACK => 115950,
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
            Symbol::WHITE => 71350,
            Symbol::BLACK => 141050,
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
            Symbol::WHITE => 34920,
            Symbol::BLACK => 181700,
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
            Symbol::WHITE => 139529,
            Symbol::BLACK => 81131,
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
            Symbol::WHITE => 158776,
            Symbol::BLACK => 103563,
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
            Symbol::WHITE => 99657,
            Symbol::BLACK => 90989,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }
}
