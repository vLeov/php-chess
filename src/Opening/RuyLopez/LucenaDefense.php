<?php

namespace PGNChess\Opening\RuyLopez;

use PGNChess\AbstractOpening;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class LucenaDefense extends AbstractOpening
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Bb5'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Be7'));

        return $this->board;
    }
}
