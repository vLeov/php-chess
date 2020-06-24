<?php

namespace PGNChess\Castling;

use PGNChess\Castling\Init as CastlingInit;
use PGNChess\PGN\Symbol;

/**
 * Can castle class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Can
{
    /*
     * Calculates whether the king can castle short.
     *
     * @param string $color
     * @param \stdClass $castling
     * @param \stdClass $control
     * @return bool
     */
    public static function short(string $color, \stdClass $castling, \stdClass $control): bool
    {
        return $castling->{$color}->{Symbol::CASTLING_SHORT} &&
            !(in_array(
                CastlingInit::info($color)->{Symbol::KING}->{Symbol::CASTLING_SHORT}->squares->f,
                $control->space->{Symbol::oppositeColor($color)})
             ) &&
            !(in_array(
                CastlingInit::info($color)->{Symbol::KING}->{Symbol::CASTLING_SHORT}->squares->g,
                $control->space->{Symbol::oppositeColor($color)})
             );
    }

    /*
     * Calculates whether the king can castle long.
     *
     * @param string $color
     * @param \stdClass $castling
     * @param \stdClass $control
     * @return bool
     */
    public static function long(string $color, \stdClass $castling, \stdClass $control): bool
    {
        return $castling->{$color}->{Symbol::CASTLING_LONG} &&
            !(in_array(
                CastlingInit::info($color)->{Symbol::KING}->{Symbol::CASTLING_LONG}->squares->b,
                $control->space->{Symbol::oppositeColor($color)})
             ) &&
            !(in_array(
                CastlingInit::info($color)->{Symbol::KING}->{Symbol::CASTLING_LONG}->squares->c,
                $control->space->{Symbol::oppositeColor($color)})
             ) &&
            !(in_array(
                CastlingInit::info($color)->{Symbol::KING}->{Symbol::CASTLING_LONG}->squares->d,
                $control->space->{Symbol::oppositeColor($color)})
             );
    }
}
