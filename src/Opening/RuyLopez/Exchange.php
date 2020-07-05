<?php

namespace PGNChess\Opening\RuyLopez;

use PGNChess\AbstractOpening;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class Exchange extends AbstractOpening
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Bb5'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'a6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Bxc6'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'dxc6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'exd4'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Qxd4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Qxd4'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nxd4'));

        return $this->board;
    }
}
