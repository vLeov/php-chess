<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\AN\Color;

class RelativeForkEvaluation extends AbstractForkEvaluation
{
    const NAME = 'relative_fork';

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
        foreach ($this->board->getPieces() as $piece) {
            if (!$piece->isKingAttacked()) {
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
