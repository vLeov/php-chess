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

        $this->weights = $this->weights();
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

        return $result;
    }

    private function weights()
    {
        $weights = [];
        $prime = 2;
        foreach ($this->heuristicPicture->getDimensions() as $key => $val) {
            $weights[] = $prime;
            $prime = (int)gmp_nextprime($prime);
        }
        $weights = array_reverse($weights);

        return $weights;
    }
}
