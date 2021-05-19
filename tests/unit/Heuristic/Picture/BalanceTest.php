<?php

namespace Chess\Tests\Unit\Heuristic\Picture;

use Chess\Board;
use Chess\Heuristic\HeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;

class BalanceTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());

        $balance = $heuristicPicture->balance($heuristicPicture->take());

        $expected = [
            [ 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $heuristicPicture = new HeuristicPicture($board->getMovetext());

        $balance = $heuristicPicture->balance($heuristicPicture->take());

        $expected = [
            [ 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }
}
