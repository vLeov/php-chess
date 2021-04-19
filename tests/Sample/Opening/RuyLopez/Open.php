<?php

namespace Chess\Tests\Sample\Opening\RuyLopez;

use Chess\Player;

class Open
{
    protected $movetext = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.O-O Nxe4';

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        return $this->player->play()->getBoard();
    }
}
