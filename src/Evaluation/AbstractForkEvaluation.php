<?php

namespace Chess\Evaluation;

use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

abstract class AbstractForkEvaluation extends AbstractEvaluation
{
    protected function attackedPieces(AbstractPiece $piece): array
    {
        $attackedPieces = [];
        foreach ($sqs = $piece->getSqs() as $sq) {
            if ($attackedPiece = $this->board->getPieceBySq($sq)) {
                if ($attackedPiece->getId() !== Piece::P) {
                    $attackedPieces[] = $attackedPiece;
                }
            }
        }

        return $attackedPieces;
    }

    protected function isKingAttacked(array $attackedPieces): bool
    {
        foreach ($attackedPieces as $attackedPiece) {
            if ($attackedPiece->getId() === Piece::K) {
                return true;
            }
        }

        return false;
    }

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
