<?php

namespace Chess\Variant\Classical\PGN\AN;

use Chess\Variant\Classical\PGN\AbstractNotation;

/**
 * Check.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class Check extends AbstractNotation
{
    const REGEX = '[\+\#]{0,1}';
}
