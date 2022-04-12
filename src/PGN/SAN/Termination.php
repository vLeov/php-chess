<?php

namespace Chess\PGN\SAN;

/**
 * Termination markers.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Termination
{
    const WHITE_WINS = '1-0';
    const BLACK_WINS = '0-1';
    const DRAW = '1/2-1/2';
    const UNKNOWN = '*';

    public static function all(): array
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }
}
