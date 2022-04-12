<?php

namespace Chess\PGN\SAN;

use Chess\Exception\UnknownNotationException;

/**
 * Algebraic notation for colors.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Color
{
    const W = 'w';
    const B = 'b';

    /**
     * Validation.
     *
     * @param string $color
     * @return string if the color is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $color): string
    {
        if ($color !== self::W && $color !== self::B) {
            throw new UnknownNotationException;
        }

        return $color;
    }

    /**
     * Returns the opposite color.
     *
     * @param string $color
     * @return string
     */
    public static function opp(?string $color): string
    {
        if ($color == self::W) {
            return self::B;
        }

        return self::W;
    }
}
