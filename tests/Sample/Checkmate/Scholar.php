<?php

namespace PGNChess\Tests\Sample\Checkmate;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\Sample\AbstractCheckmate;

class Scholar extends AbstractCheckmate
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Bc4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Qh5'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Qxf7'));

        return $this->board;
    }
}
