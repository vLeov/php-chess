<?php

namespace Chess\Variant\Capablanca100\Rule;

use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Rule\CastlingRule as ClassicalCastlingRule;

class CastlingRule extends ClassicalCastlingRule
{
    protected array $rule = [
        Color::W => [
            Piece::K => [
                Castle::SHORT => [
                    'sqs' => [ 'g1', 'h1', 'i1' ],
                    'sq' => [
                        'current' => 'f1',
                        'next' => 'i1',
                    ],
                ],
                Castle::LONG => [
                    'sqs' => [ 'b1', 'c1', 'd1', 'e1' ],
                    'sq' => [
                        'current' => 'f1',
                        'next' => 'c1',
                    ],
                ],
            ],
            Piece::R => [
                Castle::SHORT => [
                    'sq' => [
                        'current' => 'j1',
                        'next' => 'h1',
                    ],
                ],
                Castle::LONG => [
                    'sq' => [
                        'current' => 'a1',
                        'next' => 'd1',
                    ],
                ],
            ],
        ],
        Color::B => [
            Piece::K => [
                Castle::SHORT => [
                    'sqs' => [ 'g10', 'h10', 'i10' ],
                    'sq' => [
                        'current' => 'f10',
                        'next' => 'i10',
                    ],
                ],
                Castle::LONG => [
                    'sqs' => [ 'b10', 'c10', 'd10', 'e10' ],
                    'sq' => [
                        'current' => 'f10',
                        'next' => 'c10',
                    ],
                ],
            ],
            Piece::R => [
                Castle::SHORT => [
                    'sq' => [
                        'current' => 'j10',
                        'next' => 'h10',
                    ],
                ],
                Castle::LONG => [
                    'sq' => [
                        'current' => 'a10',
                        'next' => 'd10',
                    ],
                ],
            ],
        ],
    ];
}
