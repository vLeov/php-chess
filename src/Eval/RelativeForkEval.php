<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

class RelativeForkEval extends AbstractEval
{
    const NAME = 'Relative fork';

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->getPieces() as $piece) {
            if (!$piece->isAttackingKing()) {
                $attackedPieces = $piece->attackedPieces();
                if (count($attackedPieces) >= 2) {
                    $pieceValue = self::$value[$piece->getId()];
                    foreach ($attackedPieces as $attackedPiece) {
                        $attackedPieceValue = self::$value[$attackedPiece->getId()];
                        if ($pieceValue < $attackedPieceValue) {
                            $this->result[$piece->getColor()] += $attackedPieceValue;
                            $this->explain($attackedPiece);
                        }
                    }
                }
            }
        }
    }

    private function explain(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->phrases[] = "Relative fork attack on {$phrase}.";
    }
}
