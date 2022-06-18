<?php

namespace Chess\Tests\Unit;

use Chess\Game;
use Chess\Grandmaster;
use Chess\Tests\AbstractUnitTestCase;

class GrandmasterTest extends AbstractUnitTestCase
{
    const FILEPATH = __DIR__.'/../data/json/players.json';

    /**
     * @test
     */
    public function w_move()
    {
        $game = new Game(Game::MODE_GM);
        $move = (new Grandmaster(self::FILEPATH))->move($game);

        $this->assertNotEmpty($move);
    }

    /**
     * @test
     */
    public function b_move()
    {
        $game = new Game(Game::MODE_GM);
        $game->play('w', 'e4');
        $move = (new Grandmaster(self::FILEPATH))->move($game);

        $this->assertNotEmpty($move);
    }
}
