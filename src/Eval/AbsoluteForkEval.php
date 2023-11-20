<?php

namespace Chess\Eval;

class AbsoluteForkEval extends AbstractForkEval
{
    const NAME = 'Absolute fork';

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->isAttackingKing()) {
                $this->result[$piece->getColor()] =
                    $this->sumValues($piece, $piece->attackedPieces());
            }
        }

        return $this->result;
    }
}
