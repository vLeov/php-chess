<?php

namespace Chess\Eval;

use Chess\Eval\SqOutpostEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

class BishopOutpostEval extends AbstractEval
{
    const NAME = 'Bishop outpost';

    private array $sqOutpostEval;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sqOutpostEval = (new SqOutpostEval($board))->eval();

        $this->result = [
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        foreach ($this->sqOutpostEval as $key => $val) {
            foreach ($val as $sq) {
                if ($piece = $this->board->getPieceBySq($sq)) {
                    if ($piece->getColor() === $key && $piece->getId() === Piece::B) {
                        $this->result[$key] += 1;
                    }
                }
            }
        }

        return $this->result;
    }
}
