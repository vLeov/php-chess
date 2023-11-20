<?php

namespace Chess\Eval;

class RelativeForkEval extends AbstractForkEval
{
    const NAME = 'Relative fork';

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            if (!$piece->isAttackingKing()) {
                $attackedPieces = $piece->attackedPieces();
                if (count($attackedPieces) >= 2) {
                    $this->result[$piece->getColor()] =
                        $this->sumValues($piece, $attackedPieces);
                }
            }
        }

        return $this->result;
    }
}
