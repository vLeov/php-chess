<?php

namespace PGNChess\Opening\Benoni;

use PGNChess\AbstractOpening;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class BenkoGambit extends AbstractOpening
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'c4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'c5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'd5'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'b5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'cxb5'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'a6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'bxa6'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Bxa6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'd6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Bxf1'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Kxf1'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'g6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'g3'));

        return $this->board;
    }
}
