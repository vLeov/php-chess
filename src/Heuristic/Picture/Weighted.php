<?php

namespace Chess\Heuristic\Picture;

use Chess\Heuristic\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

class Weighted extends AbstractHeuristicPicture
{
    const WEIGHTS = [
        17, // material
        13, // space
        11, // center
         7, // king safety
         5, // connectivity
         3, // attack
         2, // pressure
        -2, // pressured
        -3  // attacked
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
