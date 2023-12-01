<?php

namespace Chess\Eval;

use Chess\Variant\Classical\Board;

class RelativeForkEval extends AbstractForkEval
{
    const NAME = 'Relative fork';

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->getPieces() as $piece) {
            if (!$piece->isAttackingKing()) {
                $attackedPieces = $piece->attackedPieces();
                if (count($attackedPieces) >= 2) {
                    $this->result[$piece->getColor()] =
                        $this->sumValues($piece, $attackedPieces);
                }
            }
        }
    }
}
