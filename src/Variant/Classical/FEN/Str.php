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
class Str
{
    /**
     * String validation.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws \Chess\Exception\UnknownNotationException
     */
    public function validate(string $string): string
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
    public function toAsciiArray(string $string): array
    {
        $array = [];
        $ranks = array_reverse(explode('/', $string));
        foreach ($ranks as $rank) {
            $row = [];
            preg_match_all('!\d+!', $rank, $digits, PREG_OFFSET_CAPTURE);
            preg_match_all('/[a-zA-Z]{1}/', $rank, $letters, PREG_OFFSET_CAPTURE);
            $all = array_merge($digits[0], $letters[0]);
            usort($all, function ($a, $b) {
                return $a[1] <=> $b[1];
            });
            foreach ($all as $key => $val) {
                !is_numeric($val[0])
                    ? $elem = [" {$val[0]} "]
                    : $elem = array_fill(0, $val[0], ' . ');
                $row = array_values(array_merge($row, $elem));
            }
            $array[] = $row;
        }

        return $array;
    }
}
