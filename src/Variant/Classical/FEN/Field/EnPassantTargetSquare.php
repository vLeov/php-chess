<?php

namespace Chess\Variant\Classical\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\FEN\ValidationInterface;
use Chess\Variant\Classical\PGN\AN\Square;

/**
 * En passant target square.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class EnPassantTargetSquare implements ValidationInterface
{
    /**
     * String validation.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
     public static function validate(string $value): string
     {
         if ('-' === $value) {
             return $value;
         }

         return Square::validate($value);
     }
}
