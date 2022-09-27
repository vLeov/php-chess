<?php

namespace Chess\Variant\Capablanca\PGN\AN;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Square as ClassicalSquare;

/**
 * Square.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Square extends ClassicalSquare
{
    const REGEX = '[a-j]{1}(10|[0-9]?)';

    /**
     * Returns the square's color.
     *
     * @param string $sq
     * @return string
     */
    public static function color(string $sq): string
    {
        self::validate($sq);

        $w = [
            'a2', 'a4', 'a6', 'a8', 'a10',
            'b1', 'b3', 'b5', 'b7', 'b9',
            'c2', 'c4', 'c6', 'c8', 'c10',
            'd1', 'd3', 'd5', 'd7', 'd9',
            'e2', 'e4', 'e6', 'e8', 'e10',
            'f1', 'f3', 'f5', 'f7', 'f9',
            'g2', 'g4', 'g6', 'g8', 'g10',
            'h1', 'h3', 'h5', 'h7', 'h9',
            'i2', 'i4', 'i6', 'i8', 'i10',
            'j1', 'j3', 'j5', 'j7', 'j9',
        ];

        if (in_array($sq, $w)) {
            return Color::W;
        }

        return Color::B;
    }
}
