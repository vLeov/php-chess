<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\AN\Piece;
use Chess\Piece\AbstractPiece;

/**
 * Abstract evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
abstract class AbstractEvaluation
{
    protected Board $board;

    protected array $value;

    protected array $result;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->value = [
            Piece::P => 1,
            Piece::N => 3.2,
            Piece::B => 3.33,
            Piece::K => 4,
            Piece::R => 5.1,
            Piece::Q => 8.8,
        ];
    }

    protected function attackedPieces(AbstractPiece $piece): array
    {
        $attackedPieces = [];
        foreach ($sqs = $piece->getSqs() as $sq) {
            if ($attackedPiece = $this->board->getPieceBySq($sq)) {
                $attackedPieces[] = $attackedPiece;
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
}
