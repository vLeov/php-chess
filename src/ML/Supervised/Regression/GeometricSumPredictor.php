<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristics;
use Chess\ML\Supervised\AbstractPredictor;
use Rubix\ML\Datasets\Unlabeled;

class GeometricSumPredictor extends AbstractPredictor
{
    protected function eval(Board $clone): array
    {
        $balance = (new Heuristics($clone->getMovetext(), $clone))->getResizedBalance(0, 1);

        $dataset = new Unlabeled($balance);

        $end = end($balance);

        $label = (new GeometricSumLabeller())->label($end);

        $prediction = current($this->estimator->predict($dataset));

        return [
            'label' => $label,
            'prediction' => $prediction,
            'diff' => abs($label - $prediction)
        ];
    }
}
