<?php

namespace Chess\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\SAN\Color;

/**
 * Side to move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class SideToMove implements ValidationInterface
{
     public static function validate(string $value): string
     {
         return Color::validate($value);
     }
}
