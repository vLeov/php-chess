<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Sampler;

use Chess\Board;
use Chess\ML\Supervised\Regression\Sampler\BinarySampler;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;

class BinarySamplerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board;

        $expected = [
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        $this->assertEquals($expected, (new BinarySampler($board))->sample());
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        $this->assertEquals($expected, (new BinarySampler($board))->sample());
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1],
            Symbol::BLACK => [0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0],
        ];

        $this->assertEquals($expected, (new BinarySampler($board))->sample());
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
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0],
            Symbol::BLACK => [0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0],
        ];

        $this->assertEquals($expected, (new BinarySampler($board))->sample());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();

        $expected = [
            Symbol::WHITE => [0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0],
            Symbol::BLACK => [1, 0, 0, 0, 0, 1, 1, 1, 0, 1, 1],
        ];

        $this->assertEquals($expected, (new BinarySampler($board))->sample());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();

        $expected = [
            Symbol::WHITE => [1, 1, 0, 0, 0, 1, 1, 0, 0, 1, 1],
            Symbol::BLACK => [0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0],
        ];

        $this->assertEquals($expected, (new BinarySampler($board))->sample());
    }
}
