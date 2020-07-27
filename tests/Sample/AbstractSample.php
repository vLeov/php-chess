<?php

namespace PGNChess\Tests\Sample;

use PGNChess\Player;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

abstract class AbstractSample
{
    private $player;

    public function __construct()
    {
        $this->player = new Player($this->movetext);
    }

    public function play()
    {
        foreach ($this->player->getMoves() as $move) {
            $this->player->getBoard()->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->player->getBoard()->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
        }

        return $this->player->getBoard();
    }
}
