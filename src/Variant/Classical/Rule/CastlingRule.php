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

    public function __construct()
    {
        $this->fenDist()->kPos();
    }

    public function getRule(): array
    {
        return $this->rule;
    }

    protected function fenDist(): CastlingRule
    {
        $a = $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'][0];
        $b = $this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['current'][0];
        $c = $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['current'][0];
        $d = $this->rule[Color::W][Piece::R][Castle::LONG]['sq']['current'][0];

        $diffShort = abs(ord($a) - ord($b)) - 1;
        $diffLong = abs(ord($c) - ord($d)) - 1;

        $this->rule[Color::W][Piece::K][Castle::SHORT]['fenDist'] =
            $diffShort === 0 ? '' : $diffShort;
        $this->rule[Color::W][Piece::K][Castle::LONG]['fenDist'] =
            $diffShort === 0 ? '' : $diffLong;

        return $this;
    }

    protected function kPos(): CastlingRule
    {
        $a = $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['next'][0];
        $b = $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['next'][0];

        $index = [
            'a' => 0,
            'b' => 1,
            'c' => 2,
            'd' => 3,
            'e' => 4,
            'f' => 5,
            'g' => 6,
            'h' => 7,
        ];

        $this->rule[Color::W][Piece::K][Castle::SHORT]['i'] = $index[$a];
        $this->rule[Color::W][Piece::K][Castle::LONG]['i'] = $index[$b];

        return $this;
    }
}
