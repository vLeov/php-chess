<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

class AbsolutePinEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface,
    InverseEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Absolute pin';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->range = [1, 9];

        $this->subject = [
            'Black',
            'White',
        ];

        $this->observation = [
            "has a tiny absolute pin advantage",
            "has a kind of absolute pin advantage",
            "has a significant absolute pin advantage",
            "has a total absolute pin advantage",
        ];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K) {
                $clone = unserialize(serialize($this->board));
                $pinnedPiece = $clone->getPieceBySq($piece->getSq());
                $clone->detach($pinnedPiece);
                $clone->refresh();
                $checkingPieces = $this->board->checkingPieces();
                $newCheckingPieces = $clone->checkingPieces();
                $diffPieces = $this->diffPieces($checkingPieces, $newCheckingPieces);
                foreach ($diffPieces as $diffPiece) {
                    if ($diffPiece->getColor() !== $pinnedPiece->getColor()) {
                        $this->result[$pinnedPiece->getColor()] += self::$value[$pinnedPiece->getId()];
                        $this->elaborate($pinnedPiece);
                    }
                }
            }
        }

        $this->explain($this->result);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = ucfirst("$phrase is pinned shielding the king so it cannot move out of the line of attack because the king would be put in check.");
    }
}
