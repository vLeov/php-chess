<?php

namespace Chess\Heuristic\Picture;

use Chess\Heuristic\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

class Addition extends AbstractHeuristicPicture
{
    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $this->take();

        for ($i = 0; $i < count(self::DIMENSIONS); $i++) {
            $result[Symbol::WHITE] += end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}
