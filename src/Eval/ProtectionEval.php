<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class ProtectionEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Protection';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->range = [1, 4];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a slight protection advantage",
            "has a moderate protection advantage",
            "has a decisive protection advantage",
        ];

        foreach ($this->board->getPieces() as $piece) {
            foreach ($piece->attackedPieces() as $attackedPiece) {
                if ($attackedPiece->id !== Piece::K) {
                    if (empty($attackedPiece->defendingPieces())) {
                        $this->result[$attackedPiece->oppColor()] += self::$value[$attackedPiece->id];
                        $this->elaborate($attackedPiece);
                    }
                }
            }
        }

        $this->explain($this->result);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);
        $phrase = ucfirst("$phrase is unprotected.");
        if (!in_array($phrase, $this->elaboration)) {
            $this->elaboration[] = $phrase;
        }
    }
}
