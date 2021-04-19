<?php

namespace Chess\Tests\Sample\Opening\Sicilian;

use Chess\Player;

class Open
{
    protected $movetext = '1.e4 c5 2.Nf3 d6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3';

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        return $this->player->play()->getBoard();
    }
}
