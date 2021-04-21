<?php

namespace Chess\Heuristic\Picture;

use Chess\Heuristic\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

class Weighted extends AbstractHeuristicPicture
{
    const WEIGHTS = [
        601,    // meterial
        503,    // king safety
        401,    // center
        307,    // connectivity
        211,    // space
        101,    // attack
    ];

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $this->take();

        for ($i = 0; $i < self::N_DIMENSIONS; $i++) {
            $result[Symbol::WHITE] += self::WEIGHTS[$i] * end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += self::WEIGHTS[$i] * end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}
