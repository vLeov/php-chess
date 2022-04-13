<?php

namespace Chess\PGN\AN;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\AbstractNotation;
use Chess\PGN\ValidationInterface;

/**
 * Square.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Square extends AbstractNotation implements ValidationInterface
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
