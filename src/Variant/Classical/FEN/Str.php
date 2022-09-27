<?php

namespace Chess\Variant\Classical\FEN;

use Chess\Variant\Classical\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\FEN\Field\EnPassantTargetSquare;
use Chess\Variant\Classical\FEN\Field\PiecePlacement;
use Chess\Variant\Classical\FEN\Field\SideToMove;

/**
 * FEN string.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Str implements ValidationInterface
{
    /**
     * String validation.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws \Chess\Exception\UnknownNotationException
     */
    public static function validate(string $string): string
    {
        $fields = explode(' ', $string);

        PiecePlacement::validate($fields[0]);
        SideToMove::validate($fields[1]);
        CastlingAbility::validate($fields[2]);
        EnPassantTargetSquare::validate($fields[3]);

        return $string;
    }

    /**
     * Returns an ASCII array.
     *
     * @param string $string
     * @return array
     */
    public static function toAsciiArray(string $string): array
    {
        $array = [];
        $ranks = array_reverse(explode('/', $string));
        foreach ($ranks as $rank) {
            $row = [];
            foreach ($chars = str_split($rank) as $char) {
                if (is_numeric($char)) {
                    for ($i = 0; $i <= $char - 1; $i++) {
                        $row[] = ' . ';
                    }
                } else {
                    $row[] = " $char ";
                }
            }
            $array[] = $row;
        }
        krsort($array);

        return $array;
    }
}
