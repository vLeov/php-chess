<?php

namespace Chess\Tests\Unit;

use Chess\Board;
use Chess\Fen;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class FenTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function benko_gambit()
    {
        $fen = (new Fen('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->load();

        $pieces = $fen->getPieces();
        $castling = $fen->getCastling();
        $turn = $fen->getFields()[1];

        $board = (new Board($pieces, $castling))
            ->setTurn($turn);

        $this->assertEquals($turn, Symbol::BLACK);
    }
}
