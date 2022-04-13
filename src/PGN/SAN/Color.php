<?php

namespace Chess\PGN\SAN;

use Chess\Exception\UnknownNotationException;

/**
 * Color.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Color implements ValidationInterface
{
    use BaseTrait;
    
    const W = 'w';
    const B = 'b';

    /**
     * Validate.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string
    {
        if ($value !== self::W && $value !== self::B) {
            throw new UnknownNotationException;
        }

        return $value;
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
