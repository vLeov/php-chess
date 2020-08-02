<?php

namespace PGNChess\Exception;

use PGNChess\Exception;

/**
 * Thrown when dealing with unknown PGN notation.
 *
 * @author Jordi Bassagañas
 * @link https://programarivm.com
 * @license GPL
 */
final class UnknownNotationException extends \InvalidArgumentException implements Exception
{

}
