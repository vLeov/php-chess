<?php

namespace Chess\Variant\Capablanca80\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Capablanca80\PGN\AN\Square;
use Chess\Variant\Classical\FEN\ValidationInterface;

/**
 * En passant target square.
 *
 * @author Jordi Bassagañas
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
