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

    /*
    |--------------------------------------------------------------------------
    | playUci()
    |--------------------------------------------------------------------------
    |
    | Makes a move in UCI format.
    |
    */

    /**
     * @test
     */
    public function classical_play_uci_B00()
    {
        $game = new Game(
            Game::VARIANT_CLASSICAL,
            Game::MODE_ANALYSIS
        );

        $this->assertTrue($game->playUci('w', 'e2e4'));
        $this->assertTrue($game->playUci('b', 'b8c6'));
        $this->assertTrue($game->playUci('w', 'g1f3'));
        $this->assertTrue($game->playUci('b', 'd7d6'));
        $this->assertTrue($game->playUci('w', 'f1e2'));
        $this->assertTrue($game->playUci('b', 'c8e6'));
        $this->assertTrue($game->playUci('w', 'e1g1'));
        $this->assertTrue($game->playUci('b', 'd8d7'));
        $this->assertTrue($game->playUci('w', 'h2h3'));
        $this->assertTrue($game->playUci('b', 'e8c8'));
    }
}
