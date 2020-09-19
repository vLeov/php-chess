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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0.5, 0.5, 0.5, 0.5, 0.5],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 0.5, 0.5, 0.5, 0.5, 0.5],
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0.5, 0.5, 0.5, 0.5, 0.5],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 0.5, 0.5, 0.5, 0.5, 0.5],
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 0.5, 1, 0, 1],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 1, 0.5, 0, 1, 0],
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 0.5, 0.5, 0, 0.5],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 1, 0.5, 0.5, 1, 0.5],
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0],
            Symbol::BLACK => [1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 1],
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
            Symbol::WHITE => [1, 1, 0, 0, 0, 1, 0, 1, 1, 0, 0.07, 1],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0.93, 0.4],
        ];

        $this->assertEquals($expected, (new PrimesSampler($board))->sample());
    }
}
