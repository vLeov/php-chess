<?php

namespace PGNChess\Tests\Unit;

use PGNChess\Game;
use PGNChess\Tests\AbstractUnitTestCase;

class GameTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    /* public function mode_pva()
    {
        $game = new Game(Game::MODE_PVA);
        $game->play('w', 'e4');
        $game->play('b', $game->response());
        $game->play('w', 'd4');
        $game->play('b', $game->response());

        $expected = '1.e4 c5 3.d4 b5';

        $this->assertEquals($expected, $game->movetext());
    } */

    /**
     * @dataProvider filenameData
     * @test
     */
    public function play_sample_games($filename)
    {
        $game = new Game();
        $contents = file_get_contents(self::DATA_FOLDER."/game/$filename");
        $pairs = array_filter(preg_split('/[0-9]+\./', $contents));
        $moves = [];
        foreach ($pairs as $pair) {
            $moves[] = array_values(array_filter(explode(' ', $pair)));
        }
        $moves = array_values(array_filter($moves));
        for ($i = 0; $i < count($moves); ++$i) {
            $whiteMove = str_replace("\r", '', str_replace("\n", '', $moves[$i][0]));
            $this->assertEquals(true, $game->play('w', $whiteMove));
            if (isset($moves[$i][1])) {
                $blackMove = str_replace("\r", '', str_replace("\n", '', $moves[$i][1]));
                $this->assertEquals(true, $game->play('b', $blackMove));
            }
        }
    }

    public function filenameData()
    {
        $data = [];
        for ($i = 1; $i <= 99; ++$i) {
            $i <= 9 ? $data[] = ["0$i.pgn"] : $data[] = ["$i.pgn"];
        }

        return $data;
    }
}
