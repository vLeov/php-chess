<?php

namespace Chess\ML\Supervised;

use Chess\Board;
use Chess\HeuristicPicture;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Rubix\ML\PersistentModel;

/**
 * AbstractLinearCombinationPredictor
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
abstract class AbstractLinearCombinationPredictor
{
    protected $board;

    protected $estimator;

    protected $permutations;

    protected $result = [];

    public function __construct(Board $board, PersistentModel $estimator)
    {
        $this->board = $board;

        $this->estimator = $estimator;

        $this->permutations = (new RestrictedPermutationWithRepetition())
            ->get(
                [ 8, 13, 21, 34 ],
                count((new HeuristicPicture(''))->getDimensions()),
                100
            );
    }
}
