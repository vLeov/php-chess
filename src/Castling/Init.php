<?php

namespace PGNChess\Castling;

use PGNChess\Board;
use PGNChess\Exception\CastlingException;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

/**
 * Castling initialization.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Init
{
    /**
     * Castling information.
     *
     * @param string $color
     * @return \stdClass
     */
    public static function info(string $color): \stdClass
    {
        switch ($color) {
            case Symbol::WHITE:
                return (object) [
                    Symbol::KING => (object) [
                        Symbol::CASTLING_SHORT => (object) [
                            'squares' => (object) [
                                'f' => 'f1',
                                'g' => 'g1'
                            ],
                            'position' => (object) [
                                'current' => 'e1',
                                'next' => 'g1'
                        ]],
                        Symbol::CASTLING_LONG => (object) [
                            'squares' => (object) [
                                'b' => 'b1',
                                'c' => 'c1',
                                'd' => 'd1'
                            ],
                            'position' => (object) [
                                'current' => 'e1',
                                'next' => 'c1'
                        ]]
                    ],
                    Symbol::ROOK => (object) [
                        Symbol::CASTLING_SHORT => (object) [
                            'position' => (object) [
                                'current' => 'h1',
                                'next' => 'f1'
                        ]],
                        Symbol::CASTLING_LONG => (object) [
                            'position' => (object) [
                                'current' => 'a1',
                                'next' => 'd1'
                        ]]
                    ]
                ];

            case Symbol::BLACK:
                return (object) [
                    Symbol::KING => (object) [
                        Symbol::CASTLING_SHORT => (object) [
                            'squares' => (object) [
                                'f' => 'f8',
                                'g' => 'g8'
                            ],
                            'position' => (object) [
                                'current' => 'e8',
                                'next' => 'g8'
                        ]],
                        Symbol::CASTLING_LONG => (object) [
                            'squares' => (object) [
                                'b' => 'b8',
                                'c' => 'c8',
                                'd' => 'd8'
                            ],
                            'position' => (object) [
                                'current' => 'e8',
                                'next' => 'c8'
                        ]]
                    ],
                    Symbol::ROOK => (object) [
                        Symbol::CASTLING_SHORT => (object) [
                            'position' => (object) [
                                'current' => 'h8',
                                'next' => 'f8'
                        ]],
                        Symbol::CASTLING_LONG => (object) [
                            'position' => (object) [
                                'current' => 'a8',
                                'next' => 'd8'
                        ]]
                    ]
                ];
        }
    }

    /**
     * Validates the board's castling object during initialization.
     *
     * @param Board $board
     * @return boolean
     * @throws CastlingException
     */
    public static function validate(Board $board): bool
    {
        $castlingArr = (array)$board->getCastling();

        if (!empty($castlingArr)) {
            !isset($castlingArr[Symbol::WHITE]) ?: $wCastlingArr = (array)$castlingArr[Symbol::WHITE];
            !isset($castlingArr[Symbol::BLACK]) ?: $bCastlingArr = (array)$castlingArr[Symbol::BLACK];
        }

        // check castling object

        if (empty($castlingArr)) {
            throw new CastlingException("The castling object is empty.");
        }

        if (count($castlingArr) !== 2) {
            throw new CastlingException("The castling object must have two properties.");
        }

        // check white's castling object

        if (empty($wCastlingArr)) {
            throw new CastlingException("White's castling object is not set.");
        }

        if (count($wCastlingArr) !== 3) {
            throw new CastlingException("White's castling object must have three properties.");
        }

        if (!isset($wCastlingArr['castled'])) {
            throw new CastlingException("The castled property is not set.");
        }

        if (!isset($wCastlingArr[Symbol::CASTLING_SHORT])) {
            throw new CastlingException("White's castling short property is not set.");
        }

        if (!isset($wCastlingArr[Symbol::CASTLING_LONG])) {
            throw new CastlingException("White's castling long property is not set.");
        }

        // check black's castling object

        if (empty($bCastlingArr)) {
            throw new CastlingException("Black's castling object is not set.");
        }

        if (count($bCastlingArr) !== 3) {
            throw new CastlingException("Black's castling object must have three properties.");
        }

        if (!isset($bCastlingArr['castled'])) {
            throw new CastlingException("Black's castled property is not set.");
        }

        if (!isset($bCastlingArr[Symbol::CASTLING_SHORT])) {
            throw new CastlingException("Black's castling short property is not set.");
        }

        if (!isset($bCastlingArr[Symbol::CASTLING_LONG])) {
            throw new CastlingException("Black's castling long property is not set.");
        }

        self::canCastle(
            Symbol::WHITE,
            $board->getPieceByPosition('e1'),
            $board->getPieceByPosition('a1'),
            $board->getPieceByPosition('h1'),
            $board->getCastling()
        );

        self::canCastle(
            Symbol::BLACK,
            $board->getPieceByPosition('e8'),
            $board->getPieceByPosition('a8'),
            $board->getPieceByPosition('h8'),
            $board->getCastling()
        );

        return true;
    }

    private static function canCastle($color, $king, $rookA, $rookH, $castling)
    {
        self::canCastleShort($color, $king, $rookA, $rookH, $castling);
        self::canCastleLong($color, $king, $rookA, $rookH, $castling);
    }

    private static function canCastleShort($color, $king, $rookA, $rookH, $castling)
    {
        if ($castling->{$color}->{Symbol::CASTLING_SHORT}) {
            if (!(isset($king) && $king->getIdentity() === Symbol::KING && $king->getColor() === $color)) {
                throw new CastlingException("{$color} king was already moved.");
            } elseif (!(isset($rookH) && $rookH->getIdentity() === Symbol::ROOK && $rookH->getColor() === $color)) {
                throw new CastlingException("{$color} h rook was already moved.");
            }
        }
    }

    private static function canCastleLong($color, $king, $rookA, $rookH, $castling)
    {
        if ($castling->{$color}->{Symbol::CASTLING_LONG}) {
            if (!(isset($king) && $king->getIdentity() === Symbol::KING && $king->getColor() === $color))  {
                throw new CastlingException("{$color} king was already moved.");
            } elseif (!(isset($rookA) && $rookA->getIdentity() === Symbol::ROOK && $rookA->getColor() === $color)) {
                throw new CastlingException("{$color} a rook was already moved.");
            }
        }
    }
}
