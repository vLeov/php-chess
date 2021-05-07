<?php

namespace Chess\Heuristic;

use Chess\Heuristic\Picture\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

final class LinearCombinationEvaluation implements HeuristicEvaluationInterface
{
    private $heuristicPicture;

    private $weights;

    public function __construct(AbstractHeuristicPicture $heuristicPicture)
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->weights = array_values($this->heuristicPicture->getDimensions());
    }

    public function getWeights(): array
    {
        return $this->weights;
    }

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $this->heuristicPicture->take();

        for ($i = 0; $i < count($this->heuristicPicture->getDimensions()); $i++) {
            $result[Symbol::WHITE] += $this->weights[$i] * end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += $this->weights[$i] * end($picture[Symbol::BLACK])[$i];
        }

        $result[Symbol::WHITE] = round($result[Symbol::WHITE], 2);
        $result[Symbol::BLACK] = round($result[Symbol::BLACK], 2);

        return $result;
    }
}
