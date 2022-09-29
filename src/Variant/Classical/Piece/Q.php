<?php

namespace Chess\Variant\Classical\Piece;

use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Piece\AbstractPiece;

/**
 * Queen.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Q extends Slider
{
    /**
     * @var \Chess\Variant\Classical\Piece\R
     */
    private R $rook;

    /**
     * @var \Chess\Variant\Classical\Piece\B
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
     * @return \Chess\Variant\Classical\Piece\AbstractPiece
     */
    protected function mobility(): AbstractPiece
    {
        $this->mobility = (object) [
            ... (array) $this->rook->getMobility(),
            ... (array) $this->bishop->getMobility()
        ];

        return $this;
    }
}
