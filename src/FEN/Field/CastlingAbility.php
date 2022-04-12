<?php

namespace Chess\FEN\Field;

use Chess\Exception\UnknownNotationException;

/**
 * Castling ability.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class CastlingAbility implements ValidationInterface
{
    /**
     * Validation.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string
    {
        if ($value) {
            if ('-' === $value || preg_match('/^K?Q?k?q?$/', $value)) {
                return $value;
            }
        }

        throw new UnknownNotationException;
    }
}
