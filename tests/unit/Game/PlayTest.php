<?php

namespace Chess\Tests\Unit\Game;

use Chess\Game;
use Chess\Tests\AbstractUnitTestCase;

class PlayTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_fen()
    {
        $game = new Game();

        $this->assertTrue(
            $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b')
        );
    }

    /**
     * @test
     */
    public function e4_e5_fen()
    {
        $game = new Game();
        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');

        $this->assertTrue(
            $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w')
        );
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_pgn_fen()
    {
        $game = new Game();
        $game->play('w', 'e4');
        $game->play('b', 'e5');

        $this->assertTrue(
            $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b')
        );
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_fen_pgn()
    {
        $game = new Game();
        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');
        $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w');

        $this->assertTrue(
            $game->play('w', 'Nf3')
        );
    }

    /**
     * @test
     */
    public function castling()
    {
        $game = new Game();
        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');
        $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w');
        $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b');
        $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w');
        $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQK2R b');
        $game->playFen('rnbqk2r/ppppbppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQK2R w');

        $this->assertTrue(
            $game->playFen('rnbqk2r/ppppbppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQ1RK1 b')
        );
    }
}
