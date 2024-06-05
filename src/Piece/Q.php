<?php

namespace Chess\Piece;

use Chess\Piece\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Queen.
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class Q extends Slider
{
    /**
     * @var \Chess\Piece\R
     */
    private R $rook;

    /**
     * @var \Chess\Piece\B
     */
    private B $bishop;

    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     * @param array $size
     */
    public function __construct(string $color, string $sq, array $size)
    {
        parent::__construct($color, $sq, $size, Piece::Q);

        $this->rook = new R($color, $sq, $size, RType::SLIDER);
        $this->bishop = new B($color, $sq, $size);

        $this->mobility();
    }

    /**
     * Calculates the piece's mobility.
     *
     * @return \Chess\Piece\AbstractPiece
     */
    protected function mobility(): AbstractPiece
    {
        $this->mobility = [
            ...$this->rook->getMobility(),
            ...$this->bishop->getMobility(),
        ];

        return $this;
    }
}
