<?php

namespace Chess\FEN\Field;

use Chess\Exception\UnknownNotationException;

/**
 * Piece placement.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PiecePlacement implements ValidationInterface
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
         $fields = explode('/', $value);
         if ($count = count($fields) === 8) {
             return $value;
         }

         throw new UnknownNotationException;
     }
}
