<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\HeuristicsByFenString;
use Chess\ML\Supervised\AbstractPredictor;

class GeometricSumPredictor extends AbstractPredictor
{
    protected function eval(Board $clone, float $prediction): array
    {
        $balance = (new HeuristicsByFenString($clone->toFen()))->getResizedBalance(0, 1);
        $label = (new GeometricSumLabeller())->label($balance);

        return [
            'label' => $label,
            'diff' => abs($label - $prediction)
        ];
    }
}
