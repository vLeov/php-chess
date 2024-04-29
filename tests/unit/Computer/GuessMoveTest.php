<?php

namespace Chess\Tests\Unit\Computer;

use Chess\Computer\GuessMove;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class GuessMoveTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();
        $move = (new GuessMove())->move($board);

        $this->assertNotEmpty($move);
    }

    /**
     * @test
     */
    public function scholars_mate_4_w()
    {
        $movetext = '1.e4 e5 2.Qh5 Nc6 3.Bc4 Nf6';
        $board = (new SanPlay($movetext))->validate()->getBoard();
        $move = (new GuessMove())->move($board);

        $this->assertNotEmpty($move);
    }

    /**
     * @test
     */
    public function scholars_mate_4_b()
    {
        $movetext = '1.e4 e5 2.Qh5 Nc6 3.Bc4 Nf6 Qxf7#';
        $board = (new SanPlay($movetext))->validate()->getBoard();
        $move = (new GuessMove())->move($board);

        $this->assertSame(null, $move);
    }

    /**
     * @test
     */
    public function game()
    {
        $board = new Board();
        for ($i = 0; $i < 4; $i++) {
            if ($move = (new GuessMove())->move($board)) {
                $board->play($board->getTurn(), $move->pgn);
            }
        }

        $this->assertNotEmpty($board->getMovetext());
    }
}
