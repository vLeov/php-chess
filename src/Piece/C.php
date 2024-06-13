<?php

namespace Chess\Piece;

use Chess\Piece\AbstractPiece;
use Chess\Piece\CapablancaTrait;
use Chess\Piece\N;
use Chess\Piece\R;
use Chess\Piece\RType;
use Chess\Variant\Capablanca\PGN\AN\Piece;
use Chess\Variant\Capablanca\PGN\AN\Square;

class C extends AbstractPiece
{
    use CapablancaTrait;

    private R $rook;

    private N $knight;

    public function __construct(string $color, string $sq, Square $square)
    {
        parent::__construct($color, $sq, $square, Piece::C);

        $this->rook = new R($color, $sq, $square, RType::SLIDER);
        $this->knight = new N($color, $sq, $square);

        $this->mobility();
    }

    protected function mobility(): AbstractPiece
    {
        $this->mobility = [
            ...$this->rook->mobility,
            'knight' => $this->knight->mobility,
        ];

        return $this;
    }
}
