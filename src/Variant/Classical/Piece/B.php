<?php

namespace Chess\Variant\Classical\Piece;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Piece\AbstractPiece;

/**
 * Bishop.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class B extends Slider
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
        parent::__construct($color, $sq, $size, Piece::B);

        $this->mobility = (object)[
            'upLeft' => [],
            'upRight' => [],
            'downLeft' => [],
            'downRight' => []
        ];

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
            $rank = (int)$this->sq[1] + 1;
            while (Square::validate($file.$rank)) {
                $this->mobility->upLeft[] = $file . $rank;
                $file = chr(ord($file) - 1);
                $rank = (int)$rank + 1;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = (int)$this->sq[1] + 1;
            while (Square::validate($file.$rank)) {
                $this->mobility->upRight[] = $file . $rank;
                $file = chr(ord($file) + 1);
                $rank = (int)$rank + 1;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = (int)$this->sq[1] - 1;
            while (Square::validate($file.$rank))
            {
                $this->mobility->downLeft[] = $file . $rank;
                $file = chr(ord($file) - 1);
                $rank = (int)$rank - 1;
            }
        } catch (UnknownNotationException $e) {

        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = (int)$this->sq[1] - 1;
            while (Square::validate($file.$rank))
            {
                $this->mobility->downRight[] = $file . $rank;
                $file = chr(ord($file) + 1);
                $rank = (int)$rank - 1;
            }
        } catch (UnknownNotationException $e) {

        }

        return $this;
    }
}
