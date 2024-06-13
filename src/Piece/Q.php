<?php

namespace Chess\Piece;

use Chess\Piece\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\PGN\AN\Square;

class Q extends Slider
{
    private R $rook;

    private B $bishop;

    public function __construct(string $color, string $sq, Square $square)
    {
        parent::__construct($color, $sq, $square, Piece::Q);

        $this->rook = new R($color, $sq, $square, RType::SLIDER);
        $this->bishop = new B($color, $sq, $square);

        $this->mobility();
    }

    protected function mobility(): AbstractPiece
    {
        $this->mobility = [
            ...$this->rook->mobility,
            ...$this->bishop->mobility,
        ];

        return $this;
    }
}
