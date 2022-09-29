<?php

namespace Chess\Variant\Capablanca;

use Chess\Variant\Capablanca\Piece\A;
use Chess\Variant\Capablanca\Piece\C;
use Chess\Variant\Capablanca\Rule\CastlingRule;
use Chess\Variant\Classical\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Piece\B;
use Chess\Variant\Classical\Piece\K;
use Chess\Variant\Classical\Piece\N;
use Chess\Variant\Classical\Piece\P;
use Chess\Variant\Classical\Piece\Q;
use Chess\Variant\Classical\Piece\R;
use Chess\Variant\Classical\Piece\RType;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * Board
 *
 * Chess board representation that allows to play a game of Capablanca chess in
 * Portable Game Notation (PGN) format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
final class Board extends ClassicalBoard
{
    /**
     * Constructor.
     *
     * @param array $startPos
     */
    public function __construct()
    {
        $this->size = [
            'files' => 10,
            'ranks' => 10,
        ];

        $this->castlingRule = (new CastlingRule())->getRule();

        $this->attach(new R(Color::W, 'a1', RType::CASTLE_LONG));
        $this->attach(new N(Color::W, 'b1'));
        $this->attach(new A(Color::W, 'c1'));
        $this->attach(new B(Color::W, 'd1'));
        $this->attach(new Q(Color::W, 'e1'));
        $this->attach(new K(Color::W, 'f1', $this->castlingRule));
        $this->attach(new B(Color::W, 'g1'));
        $this->attach(new C(Color::W, 'h1'));
        $this->attach(new N(Color::W, 'i1'));
        $this->attach(new R(Color::W, 'j1', RType::CASTLE_SHORT));

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

        $this->attach(new R(Color::B, 'a10', RType::CASTLE_LONG));
        $this->attach(new N(Color::B, 'b10'));
        $this->attach(new A(Color::B, 'c10'));
        $this->attach(new B(Color::B, 'd10'));
        $this->attach(new Q(Color::B, 'e10'));
        $this->attach(new K(Color::B, 'f10', $this->castlingRule));
        $this->attach(new B(Color::B, 'g10'));
        $this->attach(new C(Color::B, 'h10'));
        $this->attach(new N(Color::B, 'i10'));
        $this->attach(new R(Color::B, 'j10', RType::CASTLE_SHORT));

        $this->attach(new P(Color::B, 'a9', $this->size));
        $this->attach(new P(Color::B, 'b9', $this->size));
        $this->attach(new P(Color::B, 'c9', $this->size));
        $this->attach(new P(Color::B, 'd9', $this->size));
        $this->attach(new P(Color::B, 'e9', $this->size));
        $this->attach(new P(Color::B, 'f9', $this->size));
        $this->attach(new P(Color::B, 'g9', $this->size));
        $this->attach(new P(Color::B, 'h9', $this->size));
        $this->attach(new P(Color::B, 'i9', $this->size));
        $this->attach(new P(Color::B, 'j9', $this->size));

        $this->castlingAbility = CastlingAbility::START;

        $this->refresh();
    }
}
