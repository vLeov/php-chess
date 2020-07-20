<?php

namespace PGNChess\Tests\Sample\Opening\Sicilian;

use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\Sample\AbstractOpening;

class Closed extends AbstractOpening
{
    public function play()
    {
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'c5'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'g3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'g6'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'Bg2'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'Bg7'));
        $this->board->play(Convert::toStdObj(Symbol::WHITE, 'd3'));
        $this->board->play(Convert::toStdObj(Symbol::BLACK, 'd6'));

        return $this->board;
    }
}
