<?php

namespace Chess\Eval;

use Chess\Variant\Classical\Board;

class AbsoluteForkEval extends AbstractForkEval
{
    const NAME = 'Absolute fork';

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->isAttackingKing()) {
                $this->result[$piece->getColor()] =
                    $this->sumValues($piece, $piece->attackedPieces());
            }
        }
    }
}
