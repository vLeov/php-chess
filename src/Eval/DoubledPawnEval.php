<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class DoubledPawnEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface,
    InverseEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Doubled pawn';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1, 4];

        $this->subject = [
            'Black',
            'White',
        ];

        $this->observation = [
            "has a slight doubled pawn advantage",
            "has a moderate doubled pawn advantage",
            "has a decisive doubled pawn advantage",
        ];

        foreach ($this->board->pieces() as $piece) {
            $color = $piece->color;
            if ($piece->id === Piece::P) {
                $file = $piece->file();
                $ranks = $piece->ranks;
                if ($nextPiece = $this->board->pieceBySq($file . $ranks['next'])) {
                    if ($nextPiece->id === Piece::P && $nextPiece->color === $color) {
                        $this->result[$color] += 1;
                        $this->elaborate($nextPiece);
                    }
                }
            }
        }

        $this->explain($this->result);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = ucfirst("$phrase is doubled.");
    }
}
