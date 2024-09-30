<?php

namespace Chess\Eval;

use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class ProtectionEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Protection';

    public function __construct(AbstractBoard $board)
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

        foreach ($this->board->pieces() as $piece) {
            foreach ($piece->attacked() as $attacked) {
                if ($attacked->id !== Piece::K) {
                    if (!$attacked->defending()) {
                        $this->result[$attacked->oppColor()] += self::$value[$attacked->id];
                        $this->elaborate($attacked);
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
