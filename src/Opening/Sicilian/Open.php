<?php

namespace PGNChess\Opening\Sicilian;

use PGNChess\AbstractOpening;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class Open extends AbstractOpening
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'c5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'd6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'cxd4'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nxd4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));

        return $this->board;
    }
}
