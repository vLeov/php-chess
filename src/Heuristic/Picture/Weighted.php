<?php

namespace Chess\Heuristic\Picture;

use Chess\Heuristic\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

class Weighted extends AbstractHeuristicPicture
{
    const WEIGHTS = [
        13,     // meterial
        11,     // king safety
         7,     // center
         5,     // connectivity
         3,     // space
         2,     // attack
    ];

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $this->take();

        for ($i = 0; $i < count(self::DIMENSIONS); $i++) {
            $result[Symbol::WHITE] += self::WEIGHTS[$i] * end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += self::WEIGHTS[$i] * end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}
