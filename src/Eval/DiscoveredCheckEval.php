<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\ColorPhrase;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

class DiscoveredCheckEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Discovered check';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->range = [1, 9];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a small discovered check advantage",
            "has some discovered check advantage",
            "has a significant discovered check advantage",
            "has a total discovered check advantage",
        ];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K) {
                $clone = unserialize(serialize($this->board));
                $movingPiece = $clone->getPieceBySq($piece->getSq());
                $clone->detach($movingPiece);
                $clone->refresh();
                $checkingPieces = $this->board->checkingPieces();
                $newCheckingPieces = $clone->checkingPieces();
                $diffPieces = $this->diffPieces($checkingPieces, $newCheckingPieces);
                foreach ($diffPieces as $diffPiece) {
                    if ($diffPiece->getColor() === $movingPiece->getColor()) {
                        $this->result[$movingPiece->getColor()] += self::$value[$movingPiece->getId()];
                        $this->elaborate($movingPiece);
                    }
                }
            }
        }

        $this->explain($this->result);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);
        $sentence = ColorPhrase::sentence($piece->oppColor());

        $this->elaboration[] = ucfirst("The $sentence king can be put in check as long as $phrase moves out of the way.");
    }
}
