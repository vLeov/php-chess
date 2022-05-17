<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Composition;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

class AbsolutePinEvaluation extends AbstractEvaluation implements InverseEvaluationInterface
{
    const NAME = 'Absolute pin';

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
        $checkingPieces = $this->board->checkingPieces();
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K) {
                $comp = (new Composition($this->board))
                    ->deletePieceBySq($piece->getSq())
                    ->getBoard();
                if ($newCheckingPieces = $comp->checkingPieces()) {
                    if ($newCheckingPieces[0]->getColor() !== $piece->getColor() &&
                        count($newCheckingPieces) > count($checkingPieces)
                    ) {
                        $this->result[$piece->getColor()] += $this->value[$piece->getId()];
                    }
                }
            }
        }

        return $this->result;
    }
}
