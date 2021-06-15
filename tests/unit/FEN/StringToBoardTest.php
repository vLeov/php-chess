<?php

namespace Chess\Tests\Unit\FEN;

use Chess\Board;
use Chess\FEN\StringToBoard;;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\RuyLopez\Exchange as RuyLopezExchange;

class StringToBoardTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));

        $StringToBoard = (new StringToBoard($board))->create();

        $expected = 'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3';

        $this->assertEquals($expected, $StringToBoard);
    }

    /**
     * @test
     */
    public function e4_e5()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $StringToBoard = (new StringToBoard($board))->create();

        $expected = 'rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6';

        $this->assertEquals($expected, $StringToBoard);
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $StringToBoard = (new StringToBoard($board))->create();

        $expected = 'rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq -';

        $this->assertEquals($expected, $StringToBoard);
    }

    /**
     * @test
     */
    public function ruy_lopez_exchange()
    {
        $board = (new RuyLopezExchange(new Board()))->play();

        $StringToBoard = (new StringToBoard($board))->create();

        $expected = 'r1b1kbnr/1pp2ppp/p1p5/8/3NP3/8/PPP2PPP/RNB1K2R b KQkq -';

        $this->assertEquals($expected, $StringToBoard);
    }
}
