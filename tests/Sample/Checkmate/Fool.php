<?php

namespace PGNChess\Tests\Sample\Checkmate;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\Sample\AbstractCheckmate;

class Fool extends AbstractCheckmate
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'f3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'g4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Qh4'));

        return $this->board;
    }
}
