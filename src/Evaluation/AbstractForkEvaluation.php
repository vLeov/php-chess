<?php

namespace Chess\Evaluation;

use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

abstract class AbstractForkEvaluation extends AbstractEvaluation
{
    protected function sumValues(AbstractPiece $piece, array $attackedPieces)
    {
        $values = 0;
        $pieceValue = $this->value[$piece->getId()];
        foreach ($attackedPieces as $attackedPiece) {
            if ($attackedPiece->getId() !== Piece::K) {
                $attackedPieceValue = $this->value[$attackedPiece->getId()];
                if ($pieceValue < $attackedPieceValue) {
                    $values += $attackedPieceValue;
                }
            }
        }

        return $values;
    }
}
