<?php

namespace Chess\PGN;

use Chess\CastleRule;
use Chess\Exception\UnknownNotationException;
use Chess\PGN\SAN\Castle;
use Chess\PGN\SAN\Color;
use Chess\PGN\SAN\Piece;

/**
 * Convert class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Convert
{
    /**
     * PGN move to stdClass object.
     *
     * @param string $color
     * @param string $pgn
     * @return object
     * @throws \Chess\Exception\UnknownNotationException
     */
    public static function toObj(string $color, string $pgn): object
    {
        $isCheck = substr($pgn, -1) === '+' || substr($pgn, -1) === '#';
        if (preg_match('/^' . Move::KING . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::KING,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) [
                    'current' => null,
                    'next' => mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . Move::O_O . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::O_O,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) CastleRule::color($color)[Piece::K][Castle::O_O]['sq'],
            ];
        } elseif (preg_match('/^' . Move::O_O_O . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::O_O_O,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) CastleRule::color($color)[Piece::K][Castle::O_O_O]['sq'],
            ];
        } elseif (preg_match('/^' . Move::KING_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => Move::KING_CAPTURES,
                'color' => Color::validate($color),
                'id' => Piece::K,
                'sq' => (object) [
                    'current' => null,
                    'next' => mb_substr($pgn, -2)
                ],
            ];
        } elseif (preg_match('/^' . Move::PIECE . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::PIECE,
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
        } elseif (preg_match('/^' . Move::PIECE_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => Move::PIECE_CAPTURES,
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
        } elseif (preg_match('/^' . Move::KNIGHT . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::KNIGHT,
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
        } elseif (preg_match('/^' . Move::KNIGHT_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => Move::KNIGHT_CAPTURES,
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
        } elseif (preg_match('/^' . Move::PAWN_PROMOTES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::PAWN_PROMOTES,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'newId' => $isCheck ? mb_substr($pgn, -2, -1) : mb_substr($pgn, -1),
                'sq' => (object) [
                    'current' => null,
                    'next' => mb_substr($pgn, 0, 2)
                ],
            ];
        } elseif (preg_match('/^' . Move::PAWN_CAPTURES_AND_PROMOTES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => Move::PAWN_CAPTURES_AND_PROMOTES,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'newId' => $isCheck
                    ? mb_substr($pgn, -2, -1)
                    : mb_substr($pgn, -1),
                'sq' => (object) [
                    'current' => null,
                    'next' => mb_substr($pgn, 2, 2)
                ],
            ];
        } elseif (preg_match('/^' . Move::PAWN . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => false,
                'isCheck' => $isCheck,
                'type' => Move::PAWN,
                'color' => Color::validate($color),
                'id' => Piece::P,
                'sq' => (object) [
                    'current' => mb_substr($pgn, 0, 1),
                    'next' => $isCheck ? mb_substr($pgn, 0, -1) : $pgn
                ],
            ];
        } elseif (preg_match('/^' . Move::PAWN_CAPTURES . '$/', $pgn)) {
            return (object) [
                'pgn' => $pgn,
                'isCapture' => true,
                'isCheck' => $isCheck,
                'type' => Move::PAWN_CAPTURES,
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

    /**
     * Piece identifier to class name.
     *
     * @param string $id
     * @return string
     * @throws \Chess\Exception\UnknownNotationException
     */
    public static function toClassName(string $id): string
    {
        if ($id === Piece::B) {
            return (new \ReflectionClass('\Chess\Piece\Bishop'))->getName();
        } elseif ($id === Piece::K) {
            return (new \ReflectionClass('\Chess\Piece\King'))->getName();
        } elseif ($id === Piece::N) {
            return (new \ReflectionClass('\Chess\Piece\Knight'))->getName();
        } elseif ($id === Piece::P) {
            return (new \ReflectionClass('\Chess\Piece\Pawn'))->getName();
        } elseif ($id === Piece::Q) {
            return (new \ReflectionClass('\Chess\Piece\Queen'))->getName();
        } elseif ($id === Piece::R) {
            return (new \ReflectionClass('\Chess\Piece\Rook'))->getName();
        }

        throw new UnknownNotationException;
    }
}
