<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\PGN\Symbol;

class LinearCombinationEvaluation implements HeuristicEvaluationInterface
{
    private $heuristicPicture;

    protected $weights = [];

    public function __construct(AbstractPicture $heuristicPicture)
    {
        $this->heuristicPicture = $heuristicPicture;

        $prime = 2;
        foreach ($this->heuristicPicture->getDimensions() as $key => $val) {
            $this->weights[] = $prime;
            $prime = (int)gmp_nextprime($prime);
        }

        $this->weights = array_reverse($this->weights);
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
}
