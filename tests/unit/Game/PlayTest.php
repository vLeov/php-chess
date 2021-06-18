<?php

namespace Chess\Tests\Unit\Game;

use Chess\Ascii;
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

        $expected = [
            'legal' => true,
        ];

        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
    }

    /**
     * @test
     */
    public function e4_e5_fen()
    {
        $game = new Game();
        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');

        $expected = [
            'legal' => true,
        ];

        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w'));
    }

    /**
     * @test
     */
    public function e4_Bg6_fen()
    {
        $game = new Game();
        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');

        $expected = [
            'legal' => false,
        ];

        $this->assertEquals($expected, $game->playFen('rnbqk1nr/pppppppp/6b1/8/4P3/8/PPPP1PPP/RNBQKBNR w'));
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_pgn_fen()
    {
        $game = new Game();
        $game->play('w', 'e4');
        $game->play('b', 'e5');

        $expected = [
            'legal' => true,
        ];

        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
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

        $expected = [
            'legal' => true,
        ];

        $this->assertEquals($expected, $game->playFen('rnbqk2r/ppppbppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQ1RK1 b'));
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_Nf6_Bc4_Bc5_Ke2()
    {
        $expected = [
            'legal' => true,
        ];

        $game = new Game();
        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
        $this->assertEquals($expected, $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w'));
        $this->assertEquals($expected, $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/2B1P3/5N2/PPPP1PPP/RNBQK2R b'));
        $this->assertEquals($expected, $game->playFen('rnbqk2r/pppp1ppp/5n2/2b1p3/2B1P3/5N2/PPPP1PPP/RNBQK2R w'));
        $this->assertEquals($expected, $game->playFen('rnbqk2r/pppp1ppp/5n2/2b1p3/2B1P3/5N2/PPPPKPPP/RNBQ3R b'));
    }

    /**
     * @test
     */
    public function e4_e5_Nf3_Nf6_Bc4_Bc5_Ke2_Ke7_Nc3()
    {
        $expected = [
            'legal' => true,
        ];

        $game = new Game();
        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertEquals($expected, $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
        $this->assertEquals($expected, $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w'));
        $this->assertEquals($expected, $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/2B1P3/5N2/PPPP1PPP/RNBQK2R b'));
        $this->assertEquals($expected, $game->playFen('rnbqk2r/pppp1ppp/5n2/2b1p3/2B1P3/5N2/PPPP1PPP/RNBQK2R w'));
        $this->assertEquals($expected, $game->playFen('rnbqk2r/pppp1ppp/5n2/2b1p3/2B1P3/5N2/PPPPKPPP/RNBQ3R b'));
        $this->assertEquals($expected, $game->playFen('rnbq3r/ppppkppp/5n2/2b1p3/2B1P3/5N2/PPPPKPPP/RNBQ3R w'));
        $this->assertEquals($expected, $game->playFen('rnbq3r/ppppkppp/5n2/2b1p3/2B1P3/2N2N2/PPPPKPPP/R1BQ3R b'));
    }
}
