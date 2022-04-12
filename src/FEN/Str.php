<?php

namespace Chess\FEN;

use Chess\Exception\UnknownNotationException;
use Chess\FEN\Field\CastlingAbility;
use Chess\FEN\Field\EnPassantTargetSquare;
use Chess\FEN\Field\PiecePlacement;
use Chess\FEN\Field\SideToMove;

/**
 * Validation class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Str
{
    public static function validate(string $string): string
    {
        $fields = explode(' ', $string);

        PiecePlacement::validate($fields[0]);
        SideToMove::validate($fields[1]);
        CastlingAbility::validate($fields[2]);
        EnPassantTargetSquare::validate($fields[3]);

        return $string;
    }
}
