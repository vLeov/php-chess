<?php

namespace PGNChess\Tests\Sample\Checkmate;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Player;
use PGNChess\Tests\Sample\AbstractCheckmate;

class Fool extends AbstractCheckmate
{
    private $movetext = '1.f3 e5 2.g4 Qh4';

    public function play()
    {
        $player = new Player($this->movetext);
        foreach ($player->getMoves() as $move) {
            $player->getBoard()->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $player->getBoard()->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
        }

        return $player->getBoard();
    }
}
