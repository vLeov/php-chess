<?php

namespace Chess\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\FEN\ValidationInterface;

/**
 * Piece placement.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PiecePlacement implements ValidationInterface
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
         $fields = explode('/', $value);
         if ($count = count($fields) === 8) {
             return $value;
         }

         throw new UnknownNotationException;
     }
}
