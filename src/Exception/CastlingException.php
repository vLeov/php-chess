<?php

namespace PGNChess\Exception;

use PGNChess\Exception;

/**
 * Thrown when instantiating a custom board with an invalid castling object.
 *
 * @author Jordi Bassagañas
 * @link https://programarivm.com
 * @license GPL
 */
final class CastlingException extends \InvalidArgumentException implements Exception
{

}
