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
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
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
            Symbol::WHITE => 12.5,
            Symbol::BLACK => 28.5,
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
            Symbol::WHITE => 10,
            Symbol::BLACK => 50,
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
            Symbol::WHITE => 65.01,
            Symbol::BLACK => 15.59,
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
            Symbol::WHITE => 24.17,
            Symbol::BLACK => 13.88,
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
            Symbol::WHITE => 13.43,
            Symbol::BLACK => 6.97,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();
        $sample = (new PrimesSampler($board))->sample();

        $expected = [
            Symbol::WHITE => 13.43,
            Symbol::BLACK => 6.97,
        ];

        $this->assertEquals($expected, (new PrimesLabeller($sample))->label());
    }
}
