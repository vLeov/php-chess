<?php

namespace Chess\Piece;

use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Piece array.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class PieceArray
{
    /**
     * Array.
     *
     * @var array
     */
    protected array $array;

    /**
     * Size.
     *
     * @var array
     */
    private array $size;

    /**
     * Castling rule.
     *
     * @var array
     */
     private array $castlingRule;

    /**
     * Constructor.
     *
     * @param array $array
     * @param array $size
     * @param array $castlingRule
     */
    public function __construct(array $array, array $size, array $castlingRule)
    {
        $this->size = $size;

        $this->castlingRule = $castlingRule;

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
     * Returns the array.
     *
     * @return array
     */
     public function getArray(): array
     {
         return $this->array;
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
        if ($id === Piece::R) {
            if (
                $color === Color::B &&
                $sq === $this->castlingRule[Color::B][Piece::R][Castle::LONG]['sq']['current']
            ) {
                $this->array[] = new R($color, $sq, $this->size, RType::CASTLE_LONG);
            } elseif (
                $color === Color::B &&
                $sq === $this->castlingRule[Color::B][Piece::R][Castle::SHORT]['sq']['current']
            ) {
                $this->array[] = new R($color, $sq, $this->size, RType::CASTLE_SHORT);
            } elseif (
                $color === Color::W &&
                $sq === $this->castlingRule[Color::B][Piece::R][Castle::LONG]['sq']['current']
            ) {
                $this->array[] = new R($color, $sq, $this->size, RType::CASTLE_LONG);
            } elseif (
                $color === Color::W &&
                $sq === $this->castlingRule[Color::W][Piece::R][Castle::SHORT]['sq']['current']
            ) {
                $this->array[] = new R($color, $sq, $this->size, RType::CASTLE_SHORT);
            } else { // it doesn't matter which RType is assigned
                $this->array[] = new R($color, $sq, $this->size, RType::PROMOTED);
            }
        } else {
            $className = "\\Chess\\Piece\\$id";
            $this->array[] = new $className($color, $sq, $this->size);
        }
    }
}
