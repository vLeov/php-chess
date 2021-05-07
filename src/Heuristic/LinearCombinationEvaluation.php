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

        $result[Symbol::WHITE] = round($result[Symbol::WHITE], 2);
        $result[Symbol::BLACK] = round($result[Symbol::BLACK], 2);

        return $result;
    }

    /**
     * Assigns weights using the ranking method.
     *
     * @return array
     */
    private function weights()
    {
        $weights = [];
        foreach ($this->heuristicPicture->getDimensions() as $key => $val) {
            $weight = (count($this->heuristicPicture->getDimensions()) - $key + 2) / $this->rankSum();
            $weights[] = round($weight, 2);
        }

        return $weights;
    }

    private function rankSum()
    {
        $sum = 0;
        foreach ($this->heuristicPicture->getDimensions() as $key => $val) {
            $sum += count($this->heuristicPicture->getDimensions()) - $key + 2;
        }

        return $sum;
    }
}
