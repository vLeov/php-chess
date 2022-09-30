<?php

namespace Chess\Variant\Classical\PGN;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Check;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Classical\Piece\K;

/**
 * Move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Move extends AbstractNotation implements ValidationInterface
{
    const CASTLE_SHORT = Castle::SHORT . Check::REGEX;
    const CASTLE_LONG = Castle::LONG . Check::REGEX;
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
     * Validate.
     *
     * @param string $value
     * @return string if the value is valid
     * @throws UnknownNotationException
     */
    public static function validate(string $value): string
    {
        switch (true) {
            case preg_match('/^' . static::KING . '$/', $value):
                return $value;
            case preg_match('/^' . static::CASTLE_SHORT . '$/', $value):
                return $value;
            case preg_match('/^' . static::CASTLE_LONG . '$/', $value):
                return $value;
            case preg_match('/^' . static::KING_CAPTURES . '$/', $value):
                return $value;
            case preg_match('/^' . static::PIECE . '$/', $value):
                return $value;
            case preg_match('/^' . static::PIECE_CAPTURES . '$/', $value):
                return $value;
            case preg_match('/^' . static::KNIGHT . '$/', $value):
                return $value;
            case preg_match('/^' . static::KNIGHT_CAPTURES . '$/', $value):
                return $value;
            case preg_match('/^' . static::PAWN . '$/', $value):
                return $value;
            case preg_match('/^' . static::PAWN_CAPTURES . '$/', $value):
                return $value;
            case preg_match('/^' . static::PAWN_PROMOTES . '$/', $value):
                return $value;
            case preg_match('/^' . static::PAWN_CAPTURES_AND_PROMOTES . '$/', $value):
                return $value;
        }

        throw new UnknownNotationException;
    }

    /**
     * Returns an object for further processing.
     *
     * @param string $color
     * @param string $pgn
     * @param array $castlingRule
     * @return object
     * @throws \Chess\Exception\UnknownNotationException
     */
    public static function toObj(string $color, string $pgn, array $castlingRule): object
    {
        $isCheck = substr($pgn, -1) === '+' || substr($pgn, -1) === '#';
        if (preg_match('/^' . static::KING . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::KING,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) [
                    'current' => '',
                    'next' => mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . static::CASTLE_SHORT . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::CASTLE_SHORT,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) $castlingRule[$color][Piece::K][Castle::SHORT]['sq'],
            ];
        } elseif (preg_match('/^' . static::CASTLE_LONG . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::CASTLE_LONG,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) $castlingRule[$color][Piece::K][Castle::LONG]['sq'],
            ];
        } elseif (preg_match('/^' . static::KING_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => static::KING_CAPTURES,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) [
                    'current' => '',
                    'next' => mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . static::PIECE . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::PIECE,
                'color' => Color::validate($color),
                'id' => mb_substr($pgn, 0, 1),
                'sq' => (object) [
                    'current' => $isCheck
                        ? mb_substr(mb_substr($pgn, 0, -3), 1)
                        : mb_substr(mb_substr($pgn, 0, -2), 1),
                    'next' => $isCheck
                        ? mb_substr(mb_substr($pgn, 0, -1), -2)
                        : mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . static::PIECE_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => static::PIECE_CAPTURES,
                'color' => Color::validate($color),
                'id' => mb_substr($pgn, 0, 1),
                'sq' => (object) [
                    'current' => $isCheck
                        ? mb_substr(mb_substr($pgn, 0, -4), 1)
                        : mb_substr(mb_substr($pgn, 0, -3), 1),
                    'next' => $isCheck
                        ? mb_substr($pgn, -3, -1)
                        : mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . static::KNIGHT . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::KNIGHT,
                'color' => Color::validate($color),
                'id' => Piece::N,
                'sq' => (object) [
                    'current' => $isCheck
                        ? mb_substr(mb_substr($pgn, 0, -3), 1)
                        : mb_substr(mb_substr($pgn, 0, -2), 1),
                    'next' => $isCheck
                        ? mb_substr(mb_substr($pgn, 0, -1), -2)
                        : mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . static::KNIGHT_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => static::KNIGHT_CAPTURES,
                'color' => Color::validate($color),
                'id' => Piece::N,
                'sq' => (object) [
                    'current' => $isCheck
                        ? mb_substr(mb_substr($pgn, 0, -4), 1)
                        : mb_substr(mb_substr($pgn, 0, -3), 1),
                    'next' => $isCheck
                        ? mb_substr($pgn, -3, -1)
                        : mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . static::PAWN_PROMOTES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::PAWN_PROMOTES,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'newId' => $isCheck ? mb_substr($pgn, -2, -1) : mb_substr($pgn, -1),
                'sq' => (object) [
                    'current' => '',
                    'next' => mb_substr($pgn, 0, 2)
                ],
            ];
        } elseif (preg_match('/^' . static::PAWN_CAPTURES_AND_PROMOTES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => static::PAWN_CAPTURES_AND_PROMOTES,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'newId' => $isCheck
                    ? mb_substr($pgn, -2, -1)
                    : mb_substr($pgn, -1),
                'sq' => (object) [
                    'current' => '',
                    'next' => mb_substr($pgn, 2, 2)
                ],
            ];
        } elseif (preg_match('/^' . static::PAWN . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => static::PAWN,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'sq' => (object) [
                    'current' => mb_substr($pgn, 0, 1),
                    'next' => $isCheck ? mb_substr($pgn, 0, -1) : $pgn
                ],
            ];
        } elseif (preg_match('/^' . static::PAWN_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => static::PAWN_CAPTURES,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'sq' => (object) [
                    'current' => mb_substr($pgn, 0, 1),
                    'next' => $isCheck
                        ? mb_substr($pgn, -3, -1)
                        : mb_substr($pgn, -2)
                ],
            ];
        }

        throw new UnknownNotationException;
    }
}
