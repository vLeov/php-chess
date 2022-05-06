<?php

namespace Chess\Piece;

use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

/**
 * Queen class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Queen extends Slider
{
    /**
     * @var \Chess\Piece\Rook
     */
    private Rook $rook;

    /**
     * @var \Chess\Piece\Bishop
     */
    private Bishop $bishop;

    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     */
    public function __construct(string $color, string $sq)
    {
        parent::__construct($color, $sq, Piece::Q);

        $this->rook = new Rook($color, $sq, RookType::SLIDER);
        $this->bishop = new Bishop($color, $sq);

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
