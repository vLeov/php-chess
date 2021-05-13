<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;

interface EvaluationInterface
{
    public function evaluate(): array;
}
