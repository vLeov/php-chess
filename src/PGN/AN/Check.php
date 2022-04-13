<?php

namespace Chess\PGN\AN;

use Chess\PGN\AbstractNotation;

/**
 * Check.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Check extends AbstractNotation
{
    const REGEX = '[\+\#]{0,1}';
}
