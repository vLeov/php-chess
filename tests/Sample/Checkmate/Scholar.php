<?php

namespace Chess\Tests\Sample\Checkmate;

use Chess\Player;

class Scholar
{
    protected $movetext = '1.e4 e5 2.Bc4 Nc6 3.Qh5 Nf6 4.Qxf7';

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        return $this->player->play()->getBoard();
    }
}
