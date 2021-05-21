<?php

namespace Chess\Heuristic;

use Chess\Heuristic\HeuristicPicture;
use Chess\PGN\Symbol;

final class LinearCombinationEvaluation implements EvaluationInterface
{
    private $heuristicPicture;

    public function __construct(HeuristicPicture $heuristicPicture)
    {
        $this->heuristicPicture = $heuristicPicture;
    }

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $weights = array_values($this->heuristicPicture->getDimensions());

        $picture = $this->heuristicPicture->take()->getPicture();

        for ($i = 0; $i < count($this->heuristicPicture->getDimensions()); $i++) {
            $result[Symbol::WHITE] += $weights[$i] * end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += $weights[$i] * end($picture[Symbol::BLACK])[$i];
        }

        $result[Symbol::WHITE] = round($result[Symbol::WHITE], 2);
        $result[Symbol::BLACK] = round($result[Symbol::BLACK], 2);

        return $result;
    }
}
