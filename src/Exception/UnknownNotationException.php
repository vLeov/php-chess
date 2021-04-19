<?php

namespace Chess\Exception;

use Chess\Exception;

/**
 * Thrown when dealing with unknown PGN notation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
final class UnknownNotationException extends \InvalidArgumentException implements Exception
{

}
