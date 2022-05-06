<?php

namespace Chess\Piece;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\AN\Square;
use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

/**
 * Knight class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Knight extends AbstractPiece
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

        $this->travel();
    }

    /**
     * Calculates the squares the piece can travel to.
     *
     * @return \Chess\Piece\AbstractPiece
     */
    protected function travel(): AbstractPiece
    {
        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = (int)$this->sq[1] + 2;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 2);
            $rank = (int)$this->sq[1] + 1;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 2);
            $rank = (int)$this->sq[1] - 1;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = (int)$this->sq[1] - 2;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = (int)$this->sq[1] - 2;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {

            $file = chr(ord($this->sq[0]) + 2);
            $rank = (int)$this->sq[1] - 1;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 2);
            $rank = (int)$this->sq[1] + 1;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = (int)$this->sq[1] + 2;
            if (Square::validate($file.$rank)) {
                $this->travel[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {

        }

        return $this;
    }

    /**
     * Gets the piece's legal moves.
     *
     * @return mixed array|null
     */
    public function sqs(): ?array
    {
        $moves = [];
        foreach ($this->travel as $sq) {
            if (in_array($sq, $this->board->getSqEval()->free)) {
                $moves[] = $sq;
            } elseif (in_array($sq, $this->board->getSqEval()->used->{$this->oppColor()})) {
                $moves[] = $sq;
            }
        }

        return $moves;
    }

    /**
     * Gets the squares defended by the piece.
     *
     * @return mixed array|null
     */
    public function defendedSqs(): ?array
    {
        $sqs = [];
        foreach ($this->travel as $sq) {
            if (in_array($sq, $this->board->getSqEval()->used->{$this->getColor()})) {
                $sqs[] = $sq;
            }
        }

        return $sqs;
    }
}
