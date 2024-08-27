<?php

namespace Chess\Eval;

use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class OverloadingEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface,
    InverseEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Overloading';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        $this->range = [1, 4];

        $this->subject = [
            'Black',
            'White',
        ];

        $this->observation = [
            "has a slight overloading advantage",
            "has a moderate overloading advantage",
            "has a total overloading advantage",
        ];

        $wKSq = $this->board->piece(Color::W, Piece::K)->sq;
        $bKSq = $this->board->piece(Color::B, Piece::K)->sq;

        foreach ($this->board->pieces() as $piece) {
            $defendedSqs = array_diff($piece->defendedSqs(), [$wKSq, $bKSq]);
            if (count($defendedSqs) > 1) {
                $this->result[$piece->color][] = $piece->sq;
                $this->elaborate($piece);
            }
        }

        $this->explain([
            Color::W => count($this->result[Color::W]),
            Color::B => count($this->result[Color::B]),
        ]);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = ucfirst("$phrase is overloaded defending more than one piece.");
    }
}
