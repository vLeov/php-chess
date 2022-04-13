<?php

namespace Chess\PGN\SAN;

/**
 * Termination.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Termination
{
    use BaseTrait;

    const WHITE_WINS = '1-0';
    const BLACK_WINS = '0-1';
    const DRAW = '1/2-1/2';
    const UNKNOWN = '*';
}
