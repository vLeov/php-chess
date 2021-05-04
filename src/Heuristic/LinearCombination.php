<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\PGN\Symbol;

class LinearCombination
{
    private $weigths = [ 17, 13, 11, 7, 5, 3, 2 ];

    public function getWeights()
    {
        return $this->weigths;
    }

    public function evaluate(AbstractPicture $heuristicPic): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $heuristicPic->take();

        for ($i = 0; $i < count($heuristicPic->getDimensions()); $i++) {
            $result[Symbol::WHITE] += $this->weigths[$i] * end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += $this->weigths[$i] * end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}
