<?php

namespace PGNChess\Tests\Unit\Heuristic\Picture;

use PGNChess\Board;
use PGNChess\Heuristic\Picture\Standard as StandardHeuristicPicture;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\Benoni\BenkoGambit;
use PGNChess\Tests\Sample\Opening\RuyLopez\Exchange as ExchangeRuyLopez;

class StandardTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board;

        $picture = (new StandardHeuristicPicture($board->getMovetext()))->take();

        $expected = [
            Symbol::WHITE => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],

            ],
            Symbol::BLACK => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $picture = (new StandardHeuristicPicture($board->getMovetext()))->take();

        $expected = [
            Symbol::WHITE => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],

            ],
            Symbol::BLACK => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function evaluate_benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();

        $evaluation = (new StandardHeuristicPicture($board->getMovetext()))->evaluate();

        $expected = [
            Symbol::WHITE => 158776,
            Symbol::BLACK => 103563,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
