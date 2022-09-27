<?php

namespace Chess\Variant\Classical\FEN;

interface ValidationInterface
{
    /**
     * String validation.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     * @link https://www.chessprogramming.org/Forsyth-Edwards_Notation
     */
    public static function validate(string $value): string;
}
