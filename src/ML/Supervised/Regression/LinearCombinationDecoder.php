<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristic\HeuristicPicture;

/**
 * LinearCombinationDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationDecoder extends AbstractDecoder
{
    protected function label(Board $clone, string $color)
    {
        $heuristicPicture = new HeuristicPicture($clone->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());
        $label = (new LinearCombinationLabeller($sample, $weights))->label()[$color];

        return $label;
    }
}
