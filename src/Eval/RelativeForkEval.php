<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Piece;

class RelativeForkEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Relative fork';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1, 9];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a slight relative fork advantage",
            "has a moderate relative fork advantage",
            "has a total relative fork advantage",
        ];

        foreach ($this->board->pieces() as $piece) {
            if (!$piece->isAttackingKing()) {
                $attacked = $piece->attacked();
                if (count($attacked) >= 2) {
                    $pieceValue = self::$value[$piece->id];
                    foreach ($attacked as $attacked) {
                        $attackedValue = self::$value[$attacked->id];
                        if ($pieceValue < $attackedValue) {
                            $this->result[$piece->color] += $attackedValue;
                            $this->elaborate($attacked);
                        }
                    }
                }
            }
        }

        $this->explain($this->result);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = "Relative fork attack on {$phrase}.";
    }
}
