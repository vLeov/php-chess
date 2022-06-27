<?php

namespace Chess\Piece;

use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

/**
 * Queen.
 *
 * @author Jordi Bassagañas
 * @license GPL
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
     */
    public function __construct(string $color, string $sq)
    {
        parent::__construct($color, $sq, Piece::Q);

        $this->rook = new R($color, $sq, RType::SLIDER);
        $this->bishop = new B($color, $sq);

        $this->mobility();
    }

    /**
     * Calculates the piece's mobility.
     *
     * @return \Chess\Piece\AbstractPiece
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
