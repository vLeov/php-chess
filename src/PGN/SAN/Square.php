<?php

namespace Chess\PGN\SAN;

use Chess\Exception\UnknownNotationException;

/**
 * Algebraic notation for squares.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Square
{
    const REGEX = '[a-h]{1}[1-8]{1}';

    /**
     * Validation.
     *
     * @param string $sq
     * @return string if the square is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $sq): string
    {
        if (!preg_match('/^' . self::REGEX . '$/', $sq)) {
            throw new UnknownNotationException;
        }

        return $sq;
    }
}
