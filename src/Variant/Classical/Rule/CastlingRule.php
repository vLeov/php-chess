<?php

namespace Chess\Variant\Classical\Rule;

use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

class CastlingRule
{
    private array $rule = [
        Color::W => [
            Piece::K => [
                Castle::SHORT => [
                    'sqs' => [ 'f1', 'g1' ],
                    'sq' => [
                        'current' => 'e1',
                        'next' => 'g1',
                    ],
                ],
                Castle::LONG => [
                    'sqs' => [ 'b1', 'c1', 'd1' ],
                    'sq' => [
                        'current' => 'e1',
                        'next' => 'c1',
                    ],
                ],
            ],
            Piece::R => [
                Castle::SHORT => [
                    'sq' => [
                        'current' => 'h1',
                        'next' => 'f1',
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
                    'sqs' => [ 'f8', 'g8' ],
                    'sq' => [
                        'current' => 'e8',
                        'next' => 'g8',
                    ],
                ],
                Castle::LONG => [
                    'sqs' => [ 'b8', 'c8', 'd8' ],
                    'sq' => [
                        'current' => 'e8',
                        'next' => 'c8',
                    ],
                ],
            ],
            Piece::R => [
                Castle::SHORT => [
                    'sq' => [
                        'current' => 'h8',
                        'next' => 'f8',
                    ],
                ],
                Castle::LONG => [
                    'sq' => [
                        'current' => 'a8',
                        'next' => 'd8',
                    ],
                ],
            ],
        ],
    ];

    public function getRule(): array
    {
        return $this->rule;
    }

    public static function distance(array $rule): array
    {
        $a = $rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'][0];
        $b = $rule[Color::W][Piece::R][Castle::SHORT]['sq']['current'][0];
        $c = $rule[Color::W][Piece::K][Castle::LONG]['sq']['current'][0];
        $d = $rule[Color::W][Piece::R][Castle::LONG]['sq']['current'][0];

        $diffShort = abs(ord($a) - ord($b)) - 1;
        $diffLong = abs(ord($c) - ord($d)) - 1;

        return [
            Castle::SHORT => $diffShort === 0 ? '' : $diffShort,
            Castle::LONG => $diffLong === 0 ? '' : $diffLong,
        ];
    }
}
