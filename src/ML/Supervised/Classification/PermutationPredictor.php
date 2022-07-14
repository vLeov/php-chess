<?php

namespace Chess\ML\Supervised\Classification;

use Chess\Board;
use Chess\HeuristicsByFenString;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\ML\Supervised\AbstractPredictor;

class PermutationPredictor extends AbstractPredictor
{
    public function __construct(Board $board, PersistentModel $estimator)
    {
        parent::__construct($board, $estimator);

        $this->permutations = (new RestrictedPermutationWithRepetition())
            ->get(
                [4, 24],
                count((new Heuristics(''))->getDimensions()),
                100
            );
    }

    protected function eval(Board $clone, int $prediction): array
    {
        $balance = (new HeuristicsByFenString($clone->toFen()))->getResizedBalance(0, 1);
        $label = (new PermutationLabeller($this->permutations))
            ->label($balance)[$this->board->getTurn()];

        return [
            'label' => $label,
            'diff' => abs($label - $prediction)
        ];
    }
}
