<?php

namespace Chess\Tests\Unit\Player;

use Chess\Player\PgnPlayer;
use Chess\Tests\AbstractUnitTestCase;

class PgnPlayerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5()
    {
        $movetext = '1.e4 e5';
        $board = (new PgnPlayer($movetext))->play()->getBoard();

        $this->assertSame($movetext, $board->getMovetext());
    }

    /**
     * @test
     */
    public function foo()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        $movetext = 'foo';
        $board = (new PgnPlayer($movetext))->play()->getBoard();
    }

    /**
     * @test
     */
    public function e4_e4()
    {
        $this->expectException(\Chess\Exception\PlayerException::class);

        $movetext = '1.e4 e4';
        $board = (new PgnPlayer($movetext))->play()->getBoard();
    }
}
