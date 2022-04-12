<?php

namespace Chess\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\SAN\Square;

/**
 * En passant target square.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class EnPassantTargetSquare implements ValidationInterface
{
    /**
     * Validation.
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
