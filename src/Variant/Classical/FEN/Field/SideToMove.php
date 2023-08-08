<?php

namespace Chess\Variant\Classical\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\FEN\ValidationInterface;
use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Side to move.
 *
 * @author Jordi Bassagaña
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
