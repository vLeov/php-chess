<?php

namespace Chess\Eval;

use Chess\Composition;
use Chess\Eval\AttackEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

class RelativePinEval extends AbstractEval
{
    const NAME = 'Relative pin';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        $attackEvalBoard = (new AttackEval($this->board))->eval();
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K && $piece->getId() !== Piece::Q) {
                $oppColor = $piece->oppColor();
                $composition = (new Composition($this->board))
                    ->deletePieceBySq($piece->getSq())
                    ->getBoard();
                $attackEvalComposition = (new AttackEval($composition))->eval();
                $attackEvalDiff = $attackEvalComposition[$oppColor] - $attackEvalBoard[$oppColor];
                if ($attackEvalDiff > 0) {
                    $this->result[$oppColor] += round($attackEvalDiff, 2);
                }
            }
        }

        return $this->result;
    }
}
