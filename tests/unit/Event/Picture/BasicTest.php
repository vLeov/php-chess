<?php

namespace Chess\Tests\Unit\Event\Picture;

use Chess\Board;
use Chess\Event\Picture\Basic as BasicEventPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class BasicTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $picture = (new BasicEventPicture($board->getMovetext()))->take();

        $expected = [
            Symbol::WHITE => [
                [0, 0, 0, 0, 0],

            ],
            Symbol::BLACK => [
                [0, 0, 0, 0, 0],
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

        $picture = (new BasicEventPicture($board->getMovetext()))->take();

        $expected = [
            Symbol::WHITE => [
                [0, 0, 0, 0, 0],

            ],
            Symbol::BLACK => [
                [0, 0, 0, 0, 0],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $movetext = (new BenkoGambit(new Board()))
                        ->play()
                        ->getMovetext();

        $picture = (new BasicEventPicture($movetext))->take();

        $expected = [
            Symbol::WHITE => [
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0],
                [0, 1, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0],
                [0, 0, 0, 0, 0],
            ],
            Symbol::BLACK => [
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $movetext = (new ScholarCheckmate(new Board()))
                        ->play()
                        ->getMovetext();

        $picture = (new BasicEventPicture($movetext))->take();

        $expected = [
            Symbol::WHITE => [
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [1, 1, 0, 0, 0],
            ],
            Symbol::BLACK => [
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }
}
