<?php

namespace Chess\ML\Supervised\Regression;

use Chess\HeuristicsByFenString;
use Chess\ML\Supervised\AbstractPredictor;
use Chess\Variant\Classical\Board;

class SumPredictor extends AbstractPredictor
{
    protected function eval(Board $clone, float $prediction): array
    {
        $balance = (new HeuristicsByFenString($clone->toFen()))->getResizedBalance(0, 1);
        $label = (new SumLabeller())->label($balance);

        return [
            'label' => $label,
            'diff' => abs($label - $prediction)
        ];
    }
}
