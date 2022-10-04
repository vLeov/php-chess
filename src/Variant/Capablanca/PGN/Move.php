<?php

namespace Chess\Variant\Capablanca\PGN;

use Chess\Variant\Capablanca\PGN\AN\Square;
use Chess\Variant\Classical\PGN\Move as ClassicalMove;
use Chess\Variant\Classical\PGN\AN\Check;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Move extends ClassicalMove
{
    const KNIGHT = 'N[a-j]{0,1}(10|[1-9]?)' . Square::REGEX . Check::REGEX;
    const KNIGHT_CAPTURES = 'N[a-j]{0,1}(10|[1-9]?)x' . Square::REGEX . Check::REGEX;
    const PAWN = Square::REGEX . Check::REGEX;
    const PAWN_CAPTURES = '[a-j]{1}x' . Square::REGEX . Check::REGEX;
    const PAWN_CAPTURES_AND_PROMOTES = '[a-j]{1}x' . Square::REGEX . '[=]{0,1}[NBRQ]{0,1}' . Check::REGEX;
    const PIECE = '[ABCRQ]{1}[a-j]{0,1}(10|[1-9]?)' . Square::REGEX . Check::REGEX;
    const PIECE_CAPTURES = '[ABCRQ]{1}[a-j]{0,1}(10|[1-9]?)x' . Square::REGEX . Check::REGEX;

    /**
     * Validate.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public function validate(string $value): string
    {
        parent::__validate($value);
    }

    protected function extractSq(string $string)
    {
        $sq = preg_replace('/[^a-j0-9 "\']/', '', $string);

        return $sq;
    }

    public function toObj(string $color, string $pgn, array $castlingRule): object
    {
        // Rewrite moves here

        return parent::toObj($color, $pgn, $castlingRule);
    }
}
