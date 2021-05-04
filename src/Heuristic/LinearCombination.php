<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\PGN\Symbol;

class LinearCombination
{
    const WEIGHTS = [
        17, // material
        13, // space
        11, // center
         7, // king safety
         5, // connectivity
         3, // pressure
         2, // attack
    ];

    private $heuristicPic;

    public function __construct(AbstractPicture $heuristicPic)
    {
        $this->heuristicPic = $heuristicPic;
    }

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $this->heuristicPic->take();

        for ($i = 0; $i < count($this->heuristicPic::DIMENSIONS); $i++) {
            $result[Symbol::WHITE] += self::WEIGHTS[$i] * end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += self::WEIGHTS[$i] * end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}
