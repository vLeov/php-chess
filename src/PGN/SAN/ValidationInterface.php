<?php

namespace Chess\PGN\SAN;

/**
 * Validation interface.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
interface ValidationInterface
{
    /**
     * Validate.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string;
}
