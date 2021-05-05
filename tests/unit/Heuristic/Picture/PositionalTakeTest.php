<?php

namespace Chess\Tests\Unit\Heuristic\Picture;

use Chess\Board;
use Chess\Heuristic\Picture\Positional as PositionalHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;

class PositionalTakeTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());

        $picture = $heuristicPicture->take();

        $expected = [
            Symbol::WHITE => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
            Symbol::BLACK => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());

        $picture = $heuristicPicture->take();

        $expected = [
            Symbol::WHITE => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
            Symbol::BLACK => [
                [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }
}
