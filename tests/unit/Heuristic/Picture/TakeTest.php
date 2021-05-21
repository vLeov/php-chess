<?php

namespace Chess\Tests\Unit\Heuristic\Picture;

use Chess\Board;
use Chess\Heuristic\HeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;

class TakeTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $pic = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
            Symbol::BLACK => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
        ];

        $this->assertEquals($expected, $pic);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $pic = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
            Symbol::BLACK => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
        ];

        $this->assertEquals($expected, $pic);
    }
}
