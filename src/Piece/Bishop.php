<?php

namespace Chess\Piece;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\AN\Square;
use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

/**
 * Bishop class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Bishop extends Slider
{
    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     */
    public function __construct(string $color, string $sq)
    {
        parent::__construct($color, $sq, Piece::B);

        $this->mobility = (object)[
            'upLeft' => [],
            'upRight' => [],
            'bottomLeft' => [],
            'bottomRight' => []
        ];

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
                $this->mobility->bottomLeft[] = $file . $rank;
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
                $this->mobility->bottomRight[] = $file . $rank;
                $file = chr(ord($file) + 1);
                $rank = (int)$rank - 1;
            }
        } catch (UnknownNotationException $e) {

        }

        return $this;
    }
}
