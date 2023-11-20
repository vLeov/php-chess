<?php

namespace Chess\Eval;

use Chess\Eval\AttackEval;
use Chess\Variant\Classical\PGN\AN\Piece;

class RelativePinEval extends AbstractEval
{
    const NAME = 'Relative pin';

    public function eval(): array
    {
        $attackEval = (new AttackEval($this->board))->eval();
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K && $piece->getId() !== Piece::Q) {
                $oppColor = $piece->oppColor();
                $clone = unserialize(serialize($this->board));
                $clone->detach($clone->getPieceBySq($piece->getSq()));
                $clone->refresh();
                $newAttackEval = (new AttackEval($clone))->eval();
                $attackEvalDiff = $newAttackEval[$oppColor] - $attackEval[$oppColor];
                if ($attackEvalDiff > 0) {
                    $this->result[$oppColor] += round($attackEvalDiff, 2);
                }
            }
        }

        return $this->result;
    }
}
