<?php

namespace Chess\PGN\SAN;

use Chess\Exception\UnknownNotationException;

/**
 * Algebraic notation for squares.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Square implements ValidationInterface
{
    const REGEX = '[a-h]{1}[1-8]{1}';

    /**
     * Validate.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string
    {
        if (!preg_match('/^' . self::REGEX . '$/', $value)) {
            throw new UnknownNotationException;
        }

        return $value;
    }
}
