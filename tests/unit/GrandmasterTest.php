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
    public function w_response()
    {
        $game = new Game(Game::MODE_GRANDMASTER);
        $response = (new Grandmaster(self::FILEPATH))->response($game);

        $this->assertNotEmpty($response);
    }

    /**
     * @test
     */
    public function b_response()
    {
        $game = new Game(Game::MODE_GRANDMASTER);
        $game->play('w', 'e4');
        $response = (new Grandmaster(self::FILEPATH))->response($game);

        $this->assertNotEmpty($response);
    }
}
