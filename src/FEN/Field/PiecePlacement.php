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
     public static function validate(string $value): string
     {
         $fields = explode('/', $value);
         if ($count = count($fields) === 8) {
             return $value;
         }

         throw new UnknownNotationException;
     }
}
