<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

class DoubledPawnEvaluation extends AbstractEvaluation implements InverseEvaluationInterface
{
    const NAME = 'Doubled pawn';

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
            $color = $piece->getColor();
            if ($piece->getId() === Piece::P) {
                $file = $piece->getFile();
                $ranks = $piece->getRanks();
                if ($nextPiece = $this->board->getPieceBySq($file.$ranks->next)) {
                    if ($nextPiece->getId() === Piece::P && $nextPiece->getColor() === $color) {
                        $this->result[$color] += 1;
                    }
                }
            }
        }

        return $this->result;
    }
}
