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
        self::properties($board->getCastling());

        self::alreadyMoved(
            Symbol::WHITE,
            $board->getPieceByPosition('e1'),
            $board->getPieceByPosition('a1'),
            $board->getPieceByPosition('h1'),
            $board->getCastling()
        );

        self::alreadyMoved(
            Symbol::BLACK,
            $board->getPieceByPosition('e8'),
            $board->getPieceByPosition('a8'),
            $board->getPieceByPosition('h8'),
            $board->getCastling()
        );

        return true;
    }

    private static function properties($castling)
    {
        $castlingArr = (array)$castling;

        if (!empty($castlingArr)) {
            !isset($castlingArr[Symbol::WHITE]) ?: $w = (array)$castlingArr[Symbol::WHITE];
            !isset($castlingArr[Symbol::BLACK]) ?: $b = (array)$castlingArr[Symbol::BLACK];
        }

        switch (true) {
            case empty($castlingArr):
                throw new CastlingException("The castling object is empty.");
            case empty($w):
                throw new CastlingException("White's castling object is not set.");
            case count($w) !== 3:
                throw new CastlingException("White's castling object must have three properties.");
            case !isset($w['castled']):
                throw new CastlingException("White's castled property is not set.");
            case !isset($w[Symbol::CASTLING_SHORT]):
                throw new CastlingException("White's castling short property is not set.");
            case !isset($w[Symbol::CASTLING_LONG]):
                throw new CastlingException("White's castling long property is not set.");
            case empty($b):
                throw new CastlingException("Black's castling object is not set.");
            case count($b) !== 3:
                throw new CastlingException("Black's castling object must have three properties.");
            case !isset($b['castled']):
                throw new CastlingException("Black's castled property is not set.");
            case !isset($b[Symbol::CASTLING_SHORT]):
                throw new CastlingException("Black's castling short property is not set.");
            case !isset($b[Symbol::CASTLING_LONG]):
                throw new CastlingException("Black's castling long property is not set.");

        }
    }

    private static function alreadyMoved($color, $e, $a, $h, $castling)
    {
        self::alreadyMovedShort($color, $e, $a, $h, $castling);
        self::alreadyMovedLong($color, $e, $a, $h, $castling);
    }

    private static function alreadyMovedShort($color, $e, $a, $h, $castling)
    {
        if ($castling->{$color}->{Symbol::CASTLING_SHORT}) {
            if (!(isset($e) && $e->getIdentity() === Symbol::KING && $e->getColor() === $color)) {
                throw new CastlingException("{$color} king was already moved.");
            } elseif (!(isset($h) && $h->getIdentity() === Symbol::ROOK && $h->getColor() === $color)) {
                throw new CastlingException("{$color} h rook was already moved.");
            }
        }
    }

    private static function alreadyMovedLong($color, $e, $a, $h, $castling)
    {
        if ($castling->{$color}->{Symbol::CASTLING_LONG}) {
            if (!(isset($e) && $e->getIdentity() === Symbol::KING && $e->getColor() === $color))  {
                throw new CastlingException("{$color} king was already moved.");
            } elseif (!(isset($a) && $a->getIdentity() === Symbol::ROOK && $a->getColor() === $color)) {
                throw new CastlingException("{$color} a rook was already moved.");
            }
        }
    }
}
