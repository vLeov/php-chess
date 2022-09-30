<?php

namespace Chess\Piece;

use Chess\Exception\UnknownNotationException;
use Chess\Piece\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Piece;

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
     * @param array $size
     */
    public function __construct(string $color, string $sq, array $size)
    {
        parent::__construct($color, $sq, $size, Piece::N);

        $this->mobility();
    }

    /**
     * Calculates the piece's mobility.
     *
     * @return \Chess\Piece\AbstractPiece
     */
    protected function mobility(): AbstractPiece
    {
        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = intval(ltrim($this->sq, $this->sq[0])) + 2;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 2);
            $rank = intval(ltrim($this->sq, $this->sq[0])) + 1;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 2);
            $rank = intval(ltrim($this->sq, $this->sq[0])) - 1;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = intval(ltrim($this->sq, $this->sq[0])) - 2;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = intval(ltrim($this->sq, $this->sq[0])) - 2;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 2);
            $rank = intval(ltrim($this->sq, $this->sq[0])) - 1;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 2);
            $rank = intval(ltrim($this->sq, $this->sq[0])) + 1;
            if ($this->isValidSq($file.$rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = intval(ltrim($this->sq, $this->sq[0])) + 2;
            if ($this->isValidSq($file.$rank)) {
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
