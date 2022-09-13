<?php

namespace Chess\Eval;

use Chess\Board;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

class OppositionEval extends AbstractEval
{
    const NAME = 'Opposition';

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
        $sqs = [];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::K) {
                $sqs[] = $piece->getSq();
            }
        }

        if ($sqs[0][0] === $sqs[1][0]) {
            if (abs($sqs[0][1] - $sqs[1][1]) === 2) {
                $this->result = [
                    Color::W => (int) ($this->board->getTurn() !== Color::W),
                    Color::B => (int) ($this->board->getTurn() !== Color::B),
                ];
            }
        }

        if ($sqs[0][1] === $sqs[1][1]) {
            if (abs(ord($file) - ord($file)) === 2) {
                $this->result = [
                    Color::W => (int) ($this->board->getTurn() !== Color::W),
                    Color::B => (int) ($this->board->getTurn() !== Color::B),
                ];
            }
        }

        return $this->result;
    }
}
