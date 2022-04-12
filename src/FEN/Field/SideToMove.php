<?php

namespace Chess\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\FEN\ValidationInterface;
use Chess\PGN\SAN\Color;

/**
 * Side to move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class SideToMove implements ValidationInterface
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
         return Color::validate($value);
     }
}
