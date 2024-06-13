<?php

namespace Chess\Piece;

use Chess\Piece\AbstractPiece;
use Chess\Piece\CapablancaTrait;
use Chess\Piece\B;
use Chess\Piece\N;
use Chess\Variant\Capablanca\PGN\AN\Piece;
use Chess\Variant\Capablanca\PGN\AN\Square;

class A extends AbstractPiece
{
    use CapablancaTrait;

    private B $bishop;

    private N $knight;

    public function __construct(string $color, string $sq, Square $square)
    {
        parent::__construct($color, $sq, $square, Piece::A);

        $this->bishop = new B($color, $sq, $square);
        $this->knight = new N($color, $sq, $square);

        $this->mobility();
    }

    protected function mobility(): AbstractPiece
    {
        $this->mobility = [
            ...$this->bishop->mobility,
            'knight' => $this->knight->mobility,
        ];

        return $this;
    }
}
