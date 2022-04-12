<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\SqOutpostEvaluation;
use Chess\PGN\SAN\Color;
use Chess\PGN\SAN\Piece;

class KnightOutpostEvaluation extends AbstractEvaluation
{
    const NAME = 'knight_outpost';

    private array $sqOutpostEval;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sqOutpostEval = (new SqOutpostEvaluation($board))->eval();

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
                    if ($piece->getColor() === $key && $piece->getId() === Piece::N) {
                        $this->result[$key] += 1;
                    }
                }
            }
        }

        return $this->result;
    }
}
