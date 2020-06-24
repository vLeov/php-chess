<?php

namespace PGNChess\Castling;

use PGNChess\PGN\Symbol;

/**
 * Castling rule.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Rule
{
    /**
     * Gets the castling rule.
     *
     * @param string $color
     * @return \stdClass
     */
    public static function color(string $color): \stdClass
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
}
