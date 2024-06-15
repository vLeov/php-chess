<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Piece;

class AbsoluteForkEval extends AbstractEval implements ElaborateEvalInterface
{
    use ElaborateEvalTrait;

    const NAME = 'Absolute fork';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        foreach ($this->board->pieces() as $piece) {
            if ($piece->isAttackingKing()) {
                $pieceValue = self::$value[$piece->id];
                foreach ($piece->attackedPieces() as $attackedPiece) {
                    if ($attackedPiece->id !== Piece::K) {
                        $attackedPieceValue = self::$value[$attackedPiece->id];
                        if ($pieceValue < $attackedPieceValue) {
                            $this->result[$piece->color] += $attackedPieceValue;
                            $this->elaborate($attackedPiece);
                        }
                    }
                }
            }
        }
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = "Absolute fork attack on {$phrase}.";
    }
}
