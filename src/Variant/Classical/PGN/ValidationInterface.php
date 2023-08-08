<?php

namespace Chess\Variant\Classical\PGN;

/**
 * Validation interface.
 *
 * @author Jordi Bassagaña
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
