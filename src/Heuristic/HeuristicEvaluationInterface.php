<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;

interface HeuristicEvaluationInterface
{
    public function getWeights(): array;

    public function evaluate(): array;
}
