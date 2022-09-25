<?php

namespace Chess\Array;

use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;
use Chess\Variant\Classical\Piece\B;
use Chess\Variant\Classical\Piece\K;
use Chess\Variant\Classical\Piece\N;
use Chess\Variant\Classical\Piece\P;
use Chess\Variant\Classical\Piece\Q;
use Chess\Variant\Classical\Piece\R;
use Chess\Variant\Classical\Piece\RType;
use Chess\Variant\Classical\Rule\CastlingRule;

/**
 * Piece array.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PieceArray extends AbstractArray
{
    private array $castlingRule;

    /**
     * Constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->castlingRule = (new CastlingRule())->getRule();

        foreach ($array as $i => $row) {
            $file = 'a';
            $rank = $i + 1;
            foreach ($row as $j => $item) {
                $char = trim($item);
                if (ctype_lower($char)) {
                    $char = strtoupper($char);
                    $this->push(Color::B, $char, $file.$rank);
                } elseif (ctype_upper($char)) {
                    $this->push(Color::W, $char, $file.$rank);
                }
                $file = chr(ord($file) + 1);
            }
        }

        return $this;
    }

    /**
     * Pushes an element into the array.
     *
     * @param string $color
     * @param string $id
     * @param string $sq
     */
    private function push(string $color, string $id, string $sq): void
    {
        if ($id === Piece::K) {
            $this->array[] = new K($color, $sq, $this->castlingRule);
        } elseif ($id === Piece::Q) {
            $this->array[] = new Q($color, $sq);
        } elseif ($id === Piece::R) {
            if ($color === Color::B && $sq === 'a8') {
                $this->array[] = new R($color, $sq, RType::CASTLE_LONG);
            } elseif ($color === Color::B && $sq === 'h8') {
                $this->array[] = new R($color, $sq, RType::CASTLE_SHORT);
            } elseif ($color === Color::W && $sq === 'a1') {
                $this->array[] = new R($color, $sq, RType::CASTLE_LONG);
            } elseif ($color === Color::W && $sq === 'h1') {
                $this->array[] = new R($color, $sq, RType::CASTLE_SHORT);
            } else { // it doesn't matter which RType is assigned
                $this->array[] = new R($color, $sq, RType::CASTLE_LONG);
            }
        } elseif ($id === Piece::B) {
            $this->array[] = new B($color, $sq);
        } elseif ($id === Piece::N) {
            $this->array[] = new N($color, $sq);
        } elseif ($id === Piece::P) {
            $this->array[] = new P($color, $sq);
        }
    }
}
