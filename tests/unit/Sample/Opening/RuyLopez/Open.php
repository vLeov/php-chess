<?php

namespace PGNChess\Tests\Unit\Sample\Opening\RuyLopez;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\Unit\Sample\AbstractOpening;

class Open extends AbstractOpening
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Bb5'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'O-O'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nxe4'));

        return $this->board;
    }
}
