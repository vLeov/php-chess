<?php

namespace Chess\Tests\Unit\Play;

use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\FEN\StrToBoard as ClassicalFenStrToBoard;

class SanPlayTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5()
    {
        $movetext = '1.e4 e5';
        $board = (new SanPlay($movetext))->play()->getBoard();

        $this->assertSame($movetext, $board->getMovetext());
    }

    /**
     * @test
     */
    public function foo()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        $movetext = 'foo';
        $board = (new SanPlay($movetext))->play()->getBoard();
    }

    /**
     * @test
     */
    public function e4_e4()
    {
        $this->expectException(\Chess\Exception\PlayException::class);

        $movetext = '1.e4 e4';
        $board = (new SanPlay($movetext))->play()->getBoard();
    }

    /**
     * @test
     */
    public function ellipsis_Nc6_Bc4()
    {
        $fen = 'rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq -';
        $board = (new ClassicalFenStrToBoard($fen))->create();
        $movetext = '2...Nc6 3.Bc4';
        $board = (new SanPlay($movetext, $board))->play()->getBoard();
        $expected = '1...Nc6 2.Bc4';

        $this->assertSame($expected, $board->getMovetext());
    }
}
