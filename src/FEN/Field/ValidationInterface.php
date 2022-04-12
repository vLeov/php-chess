<?php

namespace Chess\FEN\Field;

interface ValidationInterface
{
    /**
     * Validation.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string;
}
