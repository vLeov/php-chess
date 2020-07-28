<?php

namespace PGNChess\Tests\Sample\Opening\RuyLopez;

use PGNChess\Player;

class LucenaDefense
{
    protected $movetext = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Be7';

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        return $this->player->play()->getBoard();
    }
}
