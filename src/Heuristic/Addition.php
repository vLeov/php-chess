<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\PGN\Symbol;

class Addition
{
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
            $result[Symbol::WHITE] += end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}
