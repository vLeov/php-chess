<?php

namespace Chess\Tests\Unit;

use Chess\HeuristicFenStringToBoardPicture;
use Chess\FEN\StringToBoard;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class HeuristicFenStringToBoardPictureTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5_take_get_picture()
    {
        $board = (new StringToBoard('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2'))
            ->create();

        $pic = (new HeuristicFenStringToBoardPicture($board))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [ 1, 0.05, 0.4, 0.4, 0, 0.02, 0, 0 ],
            Symbol::BLACK => [ 1, 0.05, 0.4, 0.4, 0, 0.02, 0, 0 ],
        ];

        $this->assertEquals($expected, $pic);
    }

    /**
     * @test
     */
    public function e4_e5_take_get_balance()
    {
        $board = (new StringToBoard('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2'))
            ->create();

        $balance = (new HeuristicFenStringToBoardPicture($board))
            ->take()
            ->getBalance();

        $expected = [ 0, 0, 0, 0, 0, 0, 0, 0 ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function e4_e5_evaluate()
    {
        $board = (new StringToBoard('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2'))
            ->create();

        $evaluation = (new HeuristicFenStringToBoardPicture($board))->evaluate();

        $expected = [
            Symbol::WHITE => 43.21,
            Symbol::BLACK => 43.21,
        ];

        $this->assertEquals($expected, $evaluation);
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_Nf6_take_get_picture()
    {
        $board = (new StringToBoard('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq - 2 3'))
            ->create();

        $pic = (new HeuristicFenStringToBoardPicture($board))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [ 1, 0.05, 0.51, 0.41, 0, 0, 0, 0 ],
            Symbol::BLACK => [ 1, 0.05, 0.51, 0.41, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $pic);
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_Nf6_take_get_balance()
    {
        $board = (new StringToBoard('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq - 2 3'))
            ->create();

        $balance = (new HeuristicFenStringToBoardPicture($board))
            ->take()
            ->getBalance();

        $expected = [ 0, 0, 0, 0, 0, 0, 0, 0 ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_Nf6_evaluate()
    {
        $board = (new StringToBoard('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq - 2 3'))
            ->create();

        $evaluation = (new HeuristicFenStringToBoardPicture($board))->evaluate();

        $expected = [
            Symbol::WHITE => 44.56,
            Symbol::BLACK => 44.56,
        ];

        $this->assertEquals($expected, $evaluation);
    }

    /**
     * @test
     */
    public function benko_gambit_take_get_picture()
    {
        $board = (new StringToBoard('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->create();

        $pic = (new HeuristicFenStringToBoardPicture($board))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [ 1, 0.08, 0.5, 0.67, 0, 0.03, 0, 0 ],
            Symbol::BLACK => [ 0.97, 0.06, 0.53, 0.56, 0.08, 0.03, 0, 0 ],
        ];

        $this->assertEquals($expected, $pic);
    }

    /**
     * @test
     */
    public function benko_gambit_take_get_balance()
    {
        $board = (new StringToBoard('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->create();

        $balance = (new HeuristicFenStringToBoardPicture($board))
            ->take()
            ->getBalance();

        $expected = [ 0.03, 0.02, -0.03, 0.11, -0.08, 0, 0, 0 ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function benko_gambit_evaluate()
    {
        $board = (new StringToBoard('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->create();

        $evaluation = (new HeuristicFenStringToBoardPicture($board))->evaluate();

        $expected = [
            Symbol::WHITE => 47.14,
            Symbol::BLACK => 46.01,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
