<?php

namespace Chess\Variant\Classical\Piece;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Piece\AbstractPiece;

/**
 * Knight.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class N extends AbstractPiece
{
    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     */
    public function __construct(string $color, string $sq)
    {
        parent::__construct($color, $sq, Piece::N);

        $this->mobility();
    }

    /**
     * Calculates the piece's mobility.
     *
     * @return \Chess\Variant\Classical\Piece\AbstractPiece
     */
    protected function mobility(): AbstractPiece
    {
        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = (int)$this->sq[1] + 2;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 2);
            $rank = (int)$this->sq[1] + 1;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 2);
            $rank = (int)$this->sq[1] - 1;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = (int)$this->sq[1] - 2;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = (int)$this->sq[1] - 2;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {

            $file = chr(ord($this->sq[0]) + 2);
            $rank = (int)$this->sq[1] - 1;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 2);
            $rank = (int)$this->sq[1] + 1;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = (int)$this->sq[1] + 2;
            if (Square::validate($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

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
        foreach ($this->mobility as $sq) {
            if (in_array($sq, $this->board->getSqEval()->free)) {
                $sqs[] = $sq;
            } elseif (in_array($sq, $this->board->getSqEval()->used->{$this->oppColor()})) {
                $sqs[] = $sq;
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
        foreach ($this->mobility as $sq) {
            if (in_array($sq, $this->board->getSqEval()->used->{$this->getColor()})) {
                $sqs[] = $sq;
            }
        }

        return $sqs;
    }
}
