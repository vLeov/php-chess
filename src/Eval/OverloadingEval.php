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

        foreach ($this->board->pieces() as $piece) {
            if ($piece->id !== Piece::K) {
                $defended = $piece->defended();
                $countDefended = count($defended);
                $countAttacking = 0;
                if ($countDefended > 1) {
                    foreach ($defended as $val) {
                        if (count($val->attacking()) >= count($val->defending())) {
                            $countAttacking += 1;
                        }
                    }
                    if ($countAttacking >= 2) {
                        $this->result[$piece->color][] = $piece->sq;
                        $this->elaborate($piece);
                    }
                }
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

        $this->elaboration[] = ucfirst("$phrase is overloaded with defensive tasks.");
    }
}
