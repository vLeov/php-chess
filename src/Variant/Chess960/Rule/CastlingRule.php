<?php

namespace Chess\Variant\Chess960\Rule;

use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;
use Chess\Variant\Classical\Rule\CastlingRule as ClassicalCastlingRule;

class CastlingRule
{
    private array $startPosition;

    private array $rule;

    public function __construct(array $startPosition)
    {
        $this->startPosition = $startPosition;
        $this->rule = (new ClassicalCastlingRule())->getRule();
        $this->sq()->sqs();
    }

    public function getRule(): array
    {
        return $this->rule;
    }

    protected function sq()
    {
        $longCastlingRook = false;
        foreach ($this->startPosition as $key => $val) {
            $wSq = chr(97+$key).'1';
            $bSq = chr(97+$key).'8';
            if ($val === Piece::R) {
                if (!$longCastlingRook) {
                    $this->rule[Color::W][Piece::R][Castle::LONG]['sq']['current'] = $wSq;
                    $this->rule[Color::B][Piece::R][Castle::LONG]['sq']['current'] = $bSq;
                    $longCastlingRook = true;
                } else {
                    $this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['current'] = $wSq;
                    $this->rule[Color::B][Piece::R][Castle::SHORT]['sq']['current'] = $bSq;
                }
            } elseif ($val === Piece::K) {
                $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['current'] = $wSq;
                $this->rule[Color::B][Piece::K][Castle::LONG]['sq']['current'] = $bSq;
                $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'] = $wSq;
                $this->rule[Color::B][Piece::K][Castle::SHORT]['sq']['current'] = $bSq;
            }
        }

        return $this;
    }

    protected function sqs()
    {
        $this->rule[Color::W][Piece::K][Castle::SHORT]['sqs'] = $this->path(
            $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'],
            $this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['current']
        );

        $this->rule[Color::W][Piece::K][Castle::LONG]['sqs'] = $this->path(
            $this->rule[Color::W][Piece::R][Castle::LONG]['sq']['current'],
            $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['current']
        );

        $this->rule[Color::B][Piece::K][Castle::SHORT]['sqs'] = $this->path(
            $this->rule[Color::B][Piece::K][Castle::SHORT]['sq']['current'],
            $this->rule[Color::B][Piece::R][Castle::SHORT]['sq']['current']
        );

        $this->rule[Color::B][Piece::K][Castle::LONG]['sqs'] = $this->path(
            $this->rule[Color::B][Piece::R][Castle::LONG]['sq']['current'],
            $this->rule[Color::B][Piece::K][Castle::LONG]['sq']['current']
        );
    }

    protected function path(string $from, string $to)
    {
        $path = [];
        $i = ord($from[0]) + 1;
        $j = ord($to[0]);
        for ($i = 0; $i < $j; $i++) {
            $path[] = chr($i) . $from[1];
        }

        return $path;
    }
}
