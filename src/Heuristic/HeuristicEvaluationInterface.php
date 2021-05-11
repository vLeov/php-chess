<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;

interface HeuristicEvaluationInterface
{
    public function evaluate(): array;
}
