<?php

namespace PGNChess\Tests\Unit\ML\Supervised\Regression\Sampler\Primes;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Sampler\Primes\Sampler as PrimesSampler;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use PGNChess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use PGNChess\Tests\Sample\Opening\Benoni\BenkoGambit;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;
use PGNChess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class SamplerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board;

        $expected = [
            Symbol::WHITE => [0, 37, 0, 0, 1, 40.06, 0],
            Symbol::BLACK => [0, 37, 0, 0, 1, 40.06, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $expected = [
            Symbol::WHITE => [1, 33, 2, 0, 1, 40.06, 0],
            Symbol::BLACK => [0, 37, 0, 1, 1, 40.06, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();

        $expected = [
            Symbol::WHITE => [0, 40, 1, 3, 0, 40.06, 0],
            Symbol::BLACK => [3, 24, 2, 0, 1, 40.06, 1],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();

        $expected = [
            Symbol::WHITE => [5, 22, 2, 2, 1, 40.06, 1],
            Symbol::BLACK => [2, 35, 3, 5, -3, 39.06, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();

        $expected = [
            Symbol::WHITE => [0, 29, 3, 3, 1, 35.73, 0],
            Symbol::BLACK => [3, 33, 2, 0, 1, 34.73, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $expected = [
            Symbol::WHITE => [0, 29, 5.2, 1, 1, 39.06, 0],
            Symbol::BLACK => [1, 36, 2, 0, 1, 39.06, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board))->play();

        $expected = [
            Symbol::WHITE => [0, 29, 5.2, 1, 1, 39.06, 0],
            Symbol::BLACK => [1, 36, 2, 0, 1, 39.06, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }
}
