<?php

namespace Chess\Eval;

use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\AbstractPiece;
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
                foreach ($piece->attacked() as $attacked) {
                    if ($attacked->id !== Piece::K) {
                        if (self::$value[$piece->id] < self::$value[$attacked->id]) {
                            $this->result[$piece->color] += self::$value[$attacked->id];
                            $this->elaborate($attacked);
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
