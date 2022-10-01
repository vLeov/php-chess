<?php

namespace Chess\Piece;

use Chess\Piece\AbstractPiece;
use Chess\Piece\N;
use Chess\Piece\R;
use Chess\Piece\RType;
use Chess\Variant\Capablanca\PGN\AN\Piece;

/**
 * Chancellor.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class C extends AbstractPiece
{
    /**
     * @var \Chess\Piece\R
     */
    private R $rook;

    /**
     * @var \Chess\Piece\N
     */
    private N $knight;

    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     * @param array $size
     */
    public function __construct(string $color, string $sq, array $size)
    {
        parent::__construct($color, $sq, $size, Piece::C);

        $this->rook = new R($color, $sq, $size, RType::PROMOTED);
        $this->knight = new N($color, $sq, $size);

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
            'knight' => (array) $this->knight->getMobility()
        ];

        return $this;
    }

    /**
     * Returns the piece's legal moves.
     *
     * @return array
     */
    public function sqs(): array
    {
        $sqs = [];
        foreach ($this->mobility as $key => $val) {
            if ($key !== 'knight') {
                foreach ($val as $sq) {
                    if (
                        !in_array($sq, $this->board->getSqEval()->used->{$this->getColor()}) &&
                        !in_array($sq, $this->board->getSqEval()->used->{$this->oppColor()})
                    ) {
                        $sqs[] = $sq;
                    } elseif (in_array($sq, $this->board->getSqEval()->used->{$this->oppColor()})) {
                        $sqs[] = $sq;
                        break 1;
                    } elseif (in_array($sq, $this->board->getSqEval()->used->{$this->getColor()})) {
                        break 1;
                    }
                }
            } else {
                foreach ($val as $sq) {
                    if (in_array($sq, $this->board->getSqEval()->free)) {
                        $sqs[] = $sq;
                    } elseif (in_array($sq, $this->board->getSqEval()->used->{$this->oppColor()})) {
                        $sqs[] = $sq;
                    }
                }
            }
        }

        return $sqs;
    }

    /**
     * Returns the squares defended by the piece.
     *
     * @return mixed array|null
     */
    public function defendedSqs(): ?array
    {
        $sqs = [];
        foreach ($this->mobility as $key => $val) {
            if ($key !== 'knight') {
                foreach ($val as $sq) {
                    if (in_array($sq, $this->board->getSqEval()->used->{$this->getColor()})) {
                        $sqs[] = $sq;
                        break 1;
                    } elseif (in_array($sq, $this->board->getSqEval()->used->{$this->oppColor()})) {
                        break 1;
                    }
                }
            } else {
                foreach ($val as $sq) {
                    if (in_array($sq, $this->board->getSqEval()->used->{$this->getColor()})) {
                        $sqs[] = $sq;
                    }
                }
            }
        }

        return $sqs;
    }
}
