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
     public static function validate(string $value): string
     {
         if ('-' === $value) {
             return $value;
         }

         return Square::validate($value);
     }
}
