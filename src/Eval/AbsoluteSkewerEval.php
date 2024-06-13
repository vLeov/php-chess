<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

class AbsoluteSkewerEval extends AbstractEval implements ElaborateEvalInterface
{
    use ElaborateEvalTrait;

    const NAME = 'Absolute skewer';

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->pieces() as $piece) {
            if ($piece->isAttackingKing()) {
                $king = $this->board->getPiece($this->board->turn, Piece::K);
                $clone = $this->board->clone();
                $clone->playLan($clone->turn, $king->sq.current($king->legalSqs()));
                $attackedPieces = $piece->attackedPieces();
                $newAttackedPieces = $clone->getPieceBySq($piece->sq)->attackedPieces();
                if ($diffPieces = $this->board->diffPieces($attackedPieces, $newAttackedPieces)) {
                    if (self::$value[$piece->id] < self::$value[current($diffPieces)->id]) {
                        $this->result[$piece->color] = 1;
                        $this->elaborate($piece, $king);
                    }
                }
            }
        }
    }

    private function elaborate(AbstractPiece $attackingPiece, AbstractPiece $attackedPiece): void
    {
        $attacking = PiecePhrase::create($attackingPiece);
        $attacked = PiecePhrase::create($attackedPiece);

        $this->elaboration[] = ucfirst("when $attacked will be moved, a piece that is more valuable than $attacking may well be exposed to attack.");
    }
}
