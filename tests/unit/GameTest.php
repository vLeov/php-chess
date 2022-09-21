<?php

namespace Chess\Tests\Unit;

use Chess\Game;
use Chess\Movetext;
use Chess\Exception\UnknownNotationException;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Chess960\Board;

class GameTest extends AbstractUnitTestCase
{
    /*
    |--------------------------------------------------------------------------
    | ascii()
    |--------------------------------------------------------------------------
    |
    | Prints the ASCII representation of the game.
    |
    */

    /**
     * @test
     */
    public function ascii_kaufman_01()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_FEN
        );

        $game->loadFen('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - - bm Nf6+');

        $ascii = $game->getBoard()->toAsciiString();

        $expected = " .  r  b  q  .  r  k  . \n" .
                    " p  .  b  .  n  p  p  p \n" .
                    " .  p  .  .  p  .  .  . \n" .
                    " .  .  .  .  .  .  .  . \n" .
                    " .  B  .  p  N  .  .  . \n" .
                    " P  .  .  B  .  .  .  . \n" .
                    " .  P  .  .  .  P  P  P \n" .
                    " .  .  R  Q  .  R  .  K \n";

        $this->assertSame($expected, $ascii);
    }

    /**
     * @test
     */
    public function ascii_kaufman_01_Qg4()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_FEN
        );

        $game->loadFen('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - - bm Nf6+');
        $game->play('w', 'Qg4');

        $ascii = $game->getBoard()->toAsciiString();

        $expected = " .  r  b  q  .  r  k  . \n" .
                    " p  .  b  .  n  p  p  p \n" .
                    " .  p  .  .  p  .  .  . \n" .
                    " .  .  .  .  .  .  .  . \n" .
                    " .  B  .  p  N  .  Q  . \n" .
                    " P  .  .  B  .  .  .  . \n" .
                    " .  P  .  .  .  P  P  P \n" .
                    " .  .  R  .  .  R  .  K \n";

        $this->assertSame($expected, $ascii);
    }

    /**
     * @test
     */
    public function ascii_e4_e5_Nf3_Nc6_Bb5_a6_Ba4_b5_Bb3_Bb7_a4_Nf6_Nc3_g6_Qe2_d6_d3_Be7_Bg5_Qd7_CASTLE_LONG_CASTLE_SHORT()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_FEN
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
        $this->assertTrue($game->playFen('r1bqkbnr/pppp1ppp/2n5/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w'));
        $this->assertTrue($game->playFen('r1bqkbnr/pppp1ppp/2n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R b'));
        $this->assertTrue($game->playFen('r1bqkbnr/1ppp1ppp/p1n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R w'));
        $this->assertTrue($game->playFen('r1bqkbnr/1ppp1ppp/p1n5/4p3/B3P3/5N2/PPPP1PPP/RNBQK2R b'));
        $this->assertTrue($game->playFen('r1bqkbnr/2pp1ppp/p1n5/1p2p3/B3P3/5N2/PPPP1PPP/RNBQK2R w'));
        $this->assertTrue($game->playFen('r1bqkbnr/2pp1ppp/p1n5/1p2p3/4P3/1B3N2/PPPP1PPP/RNBQK2R b'));
        $this->assertTrue($game->playFen('r2qkbnr/1bpp1ppp/p1n5/1p2p3/4P3/1B3N2/PPPP1PPP/RNBQK2R w'));
        $this->assertTrue($game->playFen('r2qkbnr/1bpp1ppp/p1n5/1p2p3/P3P3/1B3N2/1PPP1PPP/RNBQK2R b'));
        $this->assertTrue($game->playFen('r2qkb1r/1bpp1ppp/p1n2n2/1p2p3/P3P3/1B3N2/1PPP1PPP/RNBQK2R w'));
        $this->assertTrue($game->playFen('r2qkb1r/1bpp1ppp/p1n2n2/1p2p3/P3P3/1BN2N2/1PPP1PPP/R1BQK2R b'));
        $this->assertTrue($game->playFen('r2qkb1r/1bpp1p1p/p1n2np1/1p2p3/P3P3/1BN2N2/1PPP1PPP/R1BQK2R w'));
        $this->assertTrue($game->playFen('r2qkb1r/1bpp1p1p/p1n2np1/1p2p3/P3P3/1BN2N2/1PPPQPPP/R1B1K2R b'));
        $this->assertTrue($game->playFen('r2qkb1r/1bp2p1p/p1np1np1/1p2p3/P3P3/1BN2N2/1PPPQPPP/R1B1K2R w'));
        $this->assertTrue($game->playFen('r2qkb1r/1bp2p1p/p1np1np1/1p2p3/P3P3/1BNP1N2/1PP1QPPP/R1B1K2R b'));
        $this->assertTrue($game->playFen('r2qk2r/1bp1bp1p/p1np1np1/1p2p3/P3P3/1BNP1N2/1PP1QPPP/R1B1K2R w'));
        $this->assertTrue($game->playFen('r2qk2r/1bp1bp1p/p1np1np1/1p2p1B1/P3P3/1BNP1N2/1PP1QPPP/R3K2R b'));
        $this->assertTrue($game->playFen('r3k2r/1bpqbp1p/p1np1np1/1p2p1B1/P3P3/1BNP1N2/1PP1QPPP/R3K2R w'));
        $this->assertTrue($game->playFen('r3k2r/1bpqbp1p/p1np1np1/1p2p1B1/P3P3/1BNP1N2/1PP1QPPP/R1K4R b'));
        $this->assertTrue($game->playFen('r5kr/1bpqbp1p/p1np1np1/1p2p1B1/P3P3/1BNP1N2/1PP1QPPP/2KR3R w'));

        $ascii = $game->getBoard()->toAsciiString();

        $expected = " r  .  .  .  .  r  k  . \n" .
                    " .  b  p  q  b  p  .  p \n" .
                    " p  .  n  p  .  n  p  . \n" .
                    " .  p  .  .  p  .  B  . \n" .
                    " P  .  .  .  P  .  .  . \n" .
                    " .  B  N  P  .  N  .  . \n" .
                    " .  P  P  .  Q  P  P  P \n" .
                    " .  .  K  R  .  .  .  R \n";

        $this->assertSame($expected, $ascii);
    }

    /*
    |--------------------------------------------------------------------------
    | loadFen()
    |--------------------------------------------------------------------------
    |
    | Loads a FEN string allowing to continue a chess game.
    |
    */

    /**
     * @test
     */
    public function load_fen_checkmate_king_and_rook_vs_king()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_FEN
        );

        $game->loadFen('7k/8/8/8/8/8/2K5/r7 w - - 0 1');

        $this->assertTrue($game->playFen('7k/8/8/8/8/8/1K6/r7 b'));
        $this->assertTrue($game->playFen('8/6k1/8/8/8/8/1K6/r7 w'));
    }

    /*
    |--------------------------------------------------------------------------
    | playFen()
    |--------------------------------------------------------------------------
    |
    | Plays a chess move in short FEN format; only the piece placement and
    | the side to move are required.
    |
    */

    /**
     * @test
     */
    public function classical_play_fen_foo()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertFalse($game->playFen('foo'));
    }

    /**
     * @test
     */
    public function chess960_play_fen_foo()
    {
        $game = new Game(
            Game::VARIANT_960,
            Game::MODE_ANALYSIS
        );

        $this->assertFalse($game->playFen('foo'));
    }

    /**
     * @test
     */
    public function classical_play_fen_e4()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
    }

    /**
     * @test
     */
    public function chess960_play_fen_e4()
    {
        $game = new Game(
            Game::VARIANT_960,
            Game::MODE_ANALYSIS
        );

        $startPosition = ['R', 'B', 'B', 'K', 'R', 'Q', 'N', 'N'];

        $board = new Board($startPosition);

        $game->setBoard($board);

        $this->assertFalse($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
    }

    /**
     * @test
     */
    public function classical_play_fen_e4_e5()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');

        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w'));
    }

    /**
     * @test
     */
    public function chess960_B_B_N_R_K_R_Q_N_play_fen_e4_e5()
    {
        $game = new Game(
            Game::VARIANT_960,
            Game::MODE_ANALYSIS
        );

        $startPosition = ['B', 'B', 'N', 'R', 'K', 'R', 'Q', 'N'];

        $board = new Board($startPosition);

        $game->setBoard($board);

        $this->assertTrue($game->playFen('bbnrkrqn/pppppppp/8/8/4P3/8/PPPP1PPP/BBNRKRQN b'));
        $this->assertTrue($game->playFen('bbnrkrqn/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/BBNRKRQN w'));
    }

    /**
     * @test
     */
    public function chess960_Q_R_N_B_B_K_N_R_play_fen_e4_e5()
    {
        $game = new Game(
            Game::VARIANT_960,
            Game::MODE_ANALYSIS
        );

        $startPosition = ['Q', 'R', 'N', 'B', 'B', 'K', 'N', 'R'];

        $board = new Board($startPosition);

        $game->setBoard($board);

        $this->assertTrue($game->playFen('qrnbbknr/pppppppp/8/8/4P3/8/PPPP1PPP/QRNBBKNR b'));
        $this->assertTrue($game->playFen('qrnbbknr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/QRNBBKNR w'));
    }

    /**
     * @test
     */
    public function classical_play_fen_e4_Bg6()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');

        $this->assertFalse($game->playFen('rnbqk1nr/pppppppp/6b1/8/4P3/8/PPPP1PPP/RNBQKBNR w'));
    }

    /**
     * @test
     */
    public function classical_play_fen_e4_e5_Nf3()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $game->play('w', 'e4');
        $game->play('b', 'e5');

        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
    }

    /**
     * @test
     */
    public function classical_play_fen_a4_h5_a5_h4_a6_h3_axb7_hxg2()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/P7/8/1PPPPPPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppppppp1/8/7p/P7/8/1PPPPPPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppppppp1/8/P6p/8/8/1PPPPPPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppppppp1/8/P7/7p/8/1PPPPPPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppppppp1/P7/8/7p/8/1PPPPPPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppppppp1/P7/8/8/7p/1PPPPPPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pPppppp1/8/8/8/7p/1PPPPPPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pPppppp1/8/8/8/8/1PPPPPpP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('Qnbqkbnr/p1ppppp1/8/8/8/8/1PPPPPpP/RNBQKBNR b'));
    }

    /**
     * @test
     */
    public function classical_play_fen_e4_e5_Nf3_Nf6_Bc4_Bc5_Ke2_Ke7_Nc3()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
        $this->assertTrue($game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w'));
        $this->assertTrue($game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/2B1P3/5N2/PPPP1PPP/RNBQK2R b'));
        $this->assertTrue($game->playFen('rnbqk2r/pppp1ppp/5n2/2b1p3/2B1P3/5N2/PPPP1PPP/RNBQK2R w'));
        $this->assertTrue($game->playFen('rnbqk2r/pppp1ppp/5n2/2b1p3/2B1P3/5N2/PPPPKPPP/RNBQ3R b'));
        $this->assertTrue($game->playFen('rnbq3r/ppppkppp/5n2/2b1p3/2B1P3/5N2/PPPPKPPP/RNBQ3R w'));
        $this->assertTrue($game->playFen('rnbq3r/ppppkppp/5n2/2b1p3/2B1P3/2N2N2/PPPPKPPP/R1BQ3R b'));
    }

    /**
     * @test
     */
    public function classical_play_fen_e4_d5_exd5_e5_get_piece_on_d5()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppp1pppp/8/3p4/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppp1pppp/8/3P4/8/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppp2ppp/8/3Pp3/8/8/PPPP1PPP/RNBQKBNR w'));

        $this->assertSame('P', $game->getBoard()->legalSqs('d5')->id);
    }

    /**
     * @test
     */
    public function classical_play_fen_e4_c5_Nf3_d6_d4_cxd4_Nxd4_Nf6_get_piece_on_b1()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pp1ppppp/8/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pp2pppp/3p4/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pp2pppp/3p4/2p5/3PP3/5N2/PPP2PPP/RNBQKB1R b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pp2pppp/3p4/8/3pP3/5N2/PPP2PPP/RNBQKB1R w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pp2pppp/3p4/8/3NP3/8/PPP2PPP/RNBQKB1R b'));
        $this->assertTrue($game->playFen('rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w'));

        $this->assertNotEmpty($game->getBoard()->legalSqs('b1')->sqs);
    }

    /**
     * @test
     */
    public function classical_play_fen_a_sequence_of_moves_CASTLE_SHORT()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b');
        $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w');
        $game->playFen('rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b');
        $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w');
        $game->playFen('rnbqkb1r/pppp1ppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQK2R b');
        $game->playFen('rnbqk2r/ppppbppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQK2R w');

        $this->assertTrue($game->playFen('rnbqk2r/ppppbppp/5n2/4p3/4P3/5N2/PPPPBPPP/RNBQ2KR b'));
    }

    /*
    |--------------------------------------------------------------------------
    | movetext()
    |--------------------------------------------------------------------------
    |
    | Gets the game's movetext in text format.
    |
    */

    /**
     * @test
     */
    public function movetext_e4_d5_Bb5()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppp1pppp/8/3p4/4P3/8/PPPP1PPP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/ppp1pppp/8/1B1p4/4P3/8/PPPP1PPP/RNBQK1NR b'));

        $expected = '1.e4 d5 2.Bb5+';

        $this->assertSame($expected, $game->getBoard()->getMovetext());
    }

    /**
     * @test
     */
    public function movetext_f4_e5_g4_Qh4()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playFen('rnbqkbnr/pppppppp/8/8/5P2/8/PPPPP1PP/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/5P2/8/PPPPP1PP/RNBQKBNR w'));
        $this->assertTrue($game->playFen('rnbqkbnr/pppp1ppp/8/4p3/5PP1/8/PPPPP2P/RNBQKBNR b'));
        $this->assertTrue($game->playFen('rnb1kbnr/pppp1ppp/8/4p3/5PPq/8/PPPPP2P/RNBQKBNR w'));

        $expected = '1.f4 e5 2.g4 Qh4#';

        $this->assertSame($expected, $game->getBoard()->getMovetext());
    }

    /*
    |--------------------------------------------------------------------------
    | Play sample games.
    |--------------------------------------------------------------------------
    |
    | Plays the PGN games that are found in the tests/data/pgn folder.
    |
    */

    /**
     * @test
     */
    public function play_games()
    {
        foreach (new \DirectoryIterator(self::DATA_FOLDER."/pgn/") as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $filename = $fileInfo->getFilename();
            $contents = file_get_contents(self::DATA_FOLDER."/pgn/$filename");
            $contents = (new Movetext($contents))->validate();
            $movetext = (new Movetext($contents))->getMovetext();
            $game = new Game(
                Game::VARIANT_CLASSICAL,
                Game::MODE_ANALYSIS
            );
            foreach ($movetext->moves as $key => $val) {
                if ($key % 2 === 0) {
                    $this->assertTrue($game->play('w', $val));
                } else {
                    $this->assertTrue($game->play('b', $val));
                }
            }
        }
    }
}
