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
            Symbol::WHITE => [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0, 0],
            Symbol::BLACK => [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $expected = [
            Symbol::WHITE => [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0, 0],
            Symbol::BLACK => [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0, 0],
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
            Symbol::WHITE => [0, 1, 0, 1, 0.5, 0, 0, 0],
            Symbol::BLACK => [1, 0, 1, 0, 0.5, 1, 0, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
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
            Symbol::WHITE => [0.5, 0.5, 0, 0.5, 0.5, 0, 0, 0],
            Symbol::BLACK => [0.5, 0.5, 1, 0.5, 0.5, 1, 0, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }

    /**
     * @test
     */
    public function w_e4_b_e5_w_Nf3_Nc6()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $expected = [
            Symbol::WHITE => [0, 1, 1, 1, 0.25, 1, 0, 0],
            Symbol::BLACK => [1, 0, 0.5, 0, 0.25, 1, 0, 0],
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
            Symbol::WHITE => [1, 0, 1, 0, 0, 0, 0, 0],
            Symbol::BLACK => [0, 1, 0, 1, 1, 1, 0, 1],
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
            Symbol::WHITE => [0.4, 1, 0.07, 0, 1, 1, 1, 1],
            Symbol::BLACK => [1, 0.4, 0.93, 1, 0, 0, 0, 0],
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
            Symbol::WHITE => [0.75, 0, 0.15, 1, 1, 0.19, 0, 0],
            Symbol::BLACK => [0, 0.75, 0.46, 0, 1, 0, 0, 0],
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
            Symbol::WHITE => [1, 0, 0.11, 1, 0.1, 0, 0, 0],
            Symbol::BLACK => [0, 1, 0.89, 0.24, 0.1, 0, 0, 0],
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
            Symbol::WHITE => [1, 0, 0.11, 1, 0.1, 0, 0, 0],
            Symbol::BLACK => [0, 1, 0.89, 0.24, 0.1, 0, 0, 0],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }
}
