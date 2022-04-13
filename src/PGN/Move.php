<?php

namespace Chess\PGN;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Check;
use Chess\PGN\AN\Square;

/**
 * Move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Move
{
    const O_O = Castle::SHORT . Check::REGEX;
    const O_O_O = Castle::LONG . Check::REGEX;
    const KING = 'K' . Square::REGEX . Check::REGEX;
    const KING_CAPTURES = 'Kx' . Square::REGEX . Check::REGEX;
    const PIECE = '[BRQ]{1}[a-h]{0,1}[1-8]{0,1}' . Square::REGEX . Check::REGEX;
    const PIECE_CAPTURES = '[BRQ]{1}[a-h]{0,1}[1-8]{0,1}x' . Square::REGEX . Check::REGEX;
    const KNIGHT = 'N[a-h]{0,1}[1-8]{0,1}' . Square::REGEX . Check::REGEX;
    const KNIGHT_CAPTURES = 'N[a-h]{0,1}[1-8]{0,1}x' . Square::REGEX . Check::REGEX;
    const PAWN = Square::REGEX . Check::REGEX;
    const PAWN_CAPTURES = '[a-h]{1}x' . Square::REGEX . Check::REGEX;
    const PAWN_PROMOTES = '[a-h]{1}(1|8){1}' . '[=]{0,1}[NBRQ]{0,1}' . Check::REGEX;
    const PAWN_CAPTURES_AND_PROMOTES = '[a-h]{1}x' . '[a-h]{1}(1|8){1}' . '[=]{0,1}[NBRQ]{0,1}' . Check::REGEX;

    /**
     * Validation.
     *
     * @param string $color
     * @return bool
     * @throws UnknownNotationException
     */
    public static function validate(string $move): bool
    {
        switch (true) {
            case preg_match('/^' . self::KING . '$/', $move):
                return true;
            case preg_match('/^' . self::O_O . '$/', $move):
                return true;
            case preg_match('/^' . self::O_O_O . '$/', $move):
                return true;
            case preg_match('/^' . self::KING_CAPTURES . '$/', $move):
                return true;
            case preg_match('/^' . self::PIECE . '$/', $move):
                return true;
            case preg_match('/^' . self::PIECE_CAPTURES . '$/', $move):
                return true;
            case preg_match('/^' . self::KNIGHT . '$/', $move):
                return true;
            case preg_match('/^' . self::KNIGHT_CAPTURES . '$/', $move):
                return true;
            case preg_match('/^' . self::PAWN . '$/', $move):
                return true;
            case preg_match('/^' . self::PAWN_CAPTURES . '$/', $move):
                return true;
            case preg_match('/^' . self::PAWN_PROMOTES . '$/', $move):
                return true;
            case preg_match('/^' . self::PAWN_CAPTURES_AND_PROMOTES . '$/', $move):
                return true;
            default:
                throw new UnknownNotationException;
        }
    }
}
