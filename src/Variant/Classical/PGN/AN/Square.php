<?php

namespace Chess\Variant\Classical\PGN\AN;

use Chess\Piece\AsciiArray;
use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\PGN\AbstractNotation;
use Chess\Variant\Classical\PGN\ValidationInterface;

/**
 * Square.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class Square extends AbstractNotation implements ValidationInterface
{
    const REGEX = '[a-h]{1}[1-8]{1}';

    const SIZE = [
        'files' => 8,
        'ranks' => 8,
    ];

    const EXTRACT = '/[^a-h0-9 "\']/';

    /**
     * Validate.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string
    {
        if (!preg_match('/^' . static::REGEX . '$/', $value)) {
            throw new UnknownNotationException();
        }

        return $value;
    }

    /**
     * Returns the square's color.
     *
     * @param string $sq
     * @return string
     */
     public static function color(string $sq): string
     {
        static::validate($sq);

        $file = $sq[0];
        $rank = substr($sq, 1);

        if ((ord($file) - 97) % 2 === 0) {
            if ($rank % 2 !== 0) {
                return Color::B;
            }
        } else {
            if ($rank % 2 === 0) {
                return Color::B;
            }
        }

        return Color::W;
     }

     /**
      * Returns all squares.
      *
      * @return array
      */
     public static function all(): array
     {
         $all = [];
         for ($i = 0; $i < static::SIZE['files']; $i++) {
             for ($j = 0; $j < static::SIZE['ranks']; $j++) {
                 $all[] = AsciiArray::fromIndexToAlgebraic($i, $j);
             }
         }

         return $all;
     }
}
