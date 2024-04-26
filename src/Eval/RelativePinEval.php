<?php

namespace Chess\Eval;

use Chess\Eval\AttackEval;
use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

class RelativePinEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Relative pin';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->range = [1, 9];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a small relative pin advantage",
            "has some relative pin advantage",
            "has a significant relative pin advantage",
            "has a total relative pin advantage",
        ];

        $attackEval = (new AttackEval($this->board))->getResult();

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K && $piece->getId() !== Piece::Q) {
                $clone = unserialize(serialize($this->board));
                $clone->detach($clone->getPieceBySq($piece->getSq()));
                $clone->refresh();
                $newAttackEval = (new AttackEval($clone))->getResult();
                $attackEvalDiff = $newAttackEval[$piece->oppColor()] - $attackEval[$piece->oppColor()];
                if ($attackEvalDiff > 0) {
                    $this->result[$piece->oppColor()] += round($attackEvalDiff, 2);
                    $this->elaborate($piece);
                }
            }
        }

        $this->explain($this->result);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = ucfirst("$phrase is pinned shielding a piece that is more valuable than the attacking piece.");
    }
}
