<?php

namespace PGNChess\Tests\Unit\Sample\Checkmate;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\Unit\Sample\AbstractCheckmate;

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
