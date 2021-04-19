<?php

namespace Chess\Tests\Sample\Opening\Sicilian;

use Chess\Player;

class Closed
{
    protected $movetext = '1.e4 c5 2.Nc3 Nc6 3.g3 g6 4.Bg2 Bg7 5.d3 d6';

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        return $this->player->play()->getBoard();
    }
}
