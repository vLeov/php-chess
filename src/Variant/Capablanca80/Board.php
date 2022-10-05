<?php

namespace Chess\Variant\Capablanca80;

use Chess\Piece\A;
use Chess\Piece\C;
use Chess\Piece\B;
use Chess\Piece\K;
use Chess\Piece\N;
use Chess\Piece\P;
use Chess\Piece\Q;
use Chess\Piece\R;
use Chess\Piece\RType;
use Chess\Variant\Capablanca100\Rule\CastlingRule;
use Chess\Variant\Capablanca100\PGN\Move;
use Chess\Variant\Capablanca80\PGN\AN\Square;
use Chess\Variant\Classical\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Capablanca100\Board as Capablanca100Board;

/**
 * Board
 *
 * Chess board representation that allows to play a game of Capablanca chess in
 * Portable Game Notation (PGN) format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Board extends Capablanca100Board
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->size = Square::SIZE;
        $this->castlingAbility = CastlingAbility::START;
        $this->castlingRule = (new CastlingRule())->getRule();
        $this->move = new Move();
        $this->attach(new R(Color::W, 'a1', $this->size, RType::CASTLE_LONG));
        $this->attach(new N(Color::W, 'b1', $this->size));
        $this->attach(new A(Color::W, 'c1', $this->size));
        $this->attach(new B(Color::W, 'd1', $this->size));
        $this->attach(new Q(Color::W, 'e1', $this->size));
        $this->attach(new K(Color::W, 'f1', $this->size));
        $this->attach(new B(Color::W, 'g1', $this->size));
        $this->attach(new C(Color::W, 'h1', $this->size));
        $this->attach(new N(Color::W, 'i1', $this->size));
        $this->attach(new R(Color::W, 'j1', $this->size, RType::CASTLE_SHORT));
        $this->attach(new P(Color::W, 'a2', $this->size));
        $this->attach(new P(Color::W, 'b2', $this->size));
        $this->attach(new P(Color::W, 'c2', $this->size));
        $this->attach(new P(Color::W, 'd2', $this->size));
        $this->attach(new P(Color::W, 'e2', $this->size));
        $this->attach(new P(Color::W, 'f2', $this->size));
        $this->attach(new P(Color::W, 'g2', $this->size));
        $this->attach(new P(Color::W, 'h2', $this->size));
        $this->attach(new P(Color::W, 'i2', $this->size));
        $this->attach(new P(Color::W, 'j2', $this->size));
        $this->attach(new R(Color::B, 'a8', $this->size, RType::CASTLE_LONG));
        $this->attach(new N(Color::B, 'b8', $this->size));
        $this->attach(new A(Color::B, 'c8', $this->size));
        $this->attach(new B(Color::B, 'd8', $this->size));
        $this->attach(new Q(Color::B, 'e8', $this->size));
        $this->attach(new K(Color::B, 'f8', $this->size));
        $this->attach(new B(Color::B, 'g8', $this->size));
        $this->attach(new C(Color::B, 'h8', $this->size));
        $this->attach(new N(Color::B, 'i8', $this->size));
        $this->attach(new R(Color::B, 'j8', $this->size, RType::CASTLE_SHORT));
        $this->attach(new P(Color::B, 'a7', $this->size));
        $this->attach(new P(Color::B, 'b7', $this->size));
        $this->attach(new P(Color::B, 'c7', $this->size));
        $this->attach(new P(Color::B, 'd7', $this->size));
        $this->attach(new P(Color::B, 'e7', $this->size));
        $this->attach(new P(Color::B, 'f7', $this->size));
        $this->attach(new P(Color::B, 'g7', $this->size));
        $this->attach(new P(Color::B, 'h7', $this->size));
        $this->attach(new P(Color::B, 'i7', $this->size));
        $this->attach(new P(Color::B, 'j7', $this->size));

        $this->refresh();
    }
}
