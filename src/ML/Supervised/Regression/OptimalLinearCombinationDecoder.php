<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Heuristic\HeuristicPicture;

/**
 * OptimalLinearCombinationDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class OptimalLinearCombinationDecoder extends AbstractDecoder
{
    protected function label(Board $clone, string $color)
    {
        $heuristicPicture = new HeuristicPicture($clone->getMovetext());
        $sample = $heuristicPicture->sample();
        $permutations = (new RestrictedPermutationWithRepetition())
            ->get(
                [3, 5, 8, 13, 21],
                count($heuristicPicture->getDimensions()),
                100
            );
        $label = (new OptimalLinearCombinationLabeller($sample, $permutations))->label()[$color];

        return $label;
    }
}
