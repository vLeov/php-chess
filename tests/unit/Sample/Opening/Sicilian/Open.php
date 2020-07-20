<?php

namespace PGNChess\Tests\Unit\Sample\Opening\Sicilian;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\Unit\Sample\AbstractOpening;

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
