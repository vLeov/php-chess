<?php

namespace Chess\Tests\Sample\Checkmate;

use Chess\Player;

class Fool
{
    protected $movetext = '1.f3 e5 2.g4 Qh4';

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        return $this->player->play()->getBoard();
    }
}
