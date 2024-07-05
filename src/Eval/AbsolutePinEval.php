<?php

namespace Chess\Eval;

use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\AbstractPiece;

class AbsolutePinEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface,
    InverseEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Absolute pin';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1, 9];

        $this->subject = [
            'Black',
            'White',
        ];

        $this->observation = [
            "has a slight absolute pin advantage",
            "has a moderate absolute pin advantage",
            "has a total absolute pin advantage",
        ];

        foreach ($this->board->pieces() as $piece) {
            if ($piece->isPinned()) {
                $this->result[$piece->color] += self::$value[$piece->id];
                $this->elaborate($piece);
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
