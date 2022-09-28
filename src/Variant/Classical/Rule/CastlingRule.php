<?php

namespace Chess\Variant\Classical\Rule;

use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class CastlingRule
{
    protected array $file = [
        'a' => 0,
        'b' => 1,
        'c' => 2,
        'd' => 3,
        'e' => 4,
        'f' => 5,
        'g' => 6,
        'h' => 7,
    ];

    protected array $rule = [
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
        $this->fenDist()->kPos();

        return $this->rule;
    }

    protected function fenDist(): CastlingRule
    {
        $short = abs(
            ord($this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'][0]) -
            ord($this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['current'][0])
        );

        $long = abs(
            ord($this->rule[Color::W][Piece::K][Castle::LONG]['sq']['current'][0]) -
            ord($this->rule[Color::W][Piece::R][Castle::LONG]['sq']['current'][0])
        );

        $this->rule[Color::W][Piece::K][Castle::SHORT]['fenDist'] = $short === 1 ? '' : $short - 1;
        $this->rule[Color::W][Piece::K][Castle::LONG]['fenDist'] = $long === 1 ? '' : $long - 1;

        return $this;
    }

    protected function kPos(): CastlingRule
    {
        $short = $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['next'][0];
        $long = $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['next'][0];

        $this->rule[Color::W][Piece::K][Castle::SHORT]['i'] = $this->file[$short];
        $this->rule[Color::W][Piece::K][Castle::LONG]['i'] = $this->file[$long];

        return $this;
    }
}
