<?php

namespace Chess\Eval;

use Chess\Eval\BishopPairEval;
use Chess\Piece\AbstractPiece;
use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class BadBishopEval extends AbstractEval implements
    ExplainEvalInterface,
    InverseEvalInterface
{
    use ExplainEvalTrait;

    const NAME = 'Bad bishop';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1, 5];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            'has a bishop which is not too good because a few of its pawns are blocking it',
            'has a bad bishop because too many of its pawns are blocking it',
        ];

        $bishopPairEval = (new BishopPairEval($board))->getResult();

        if (!$bishopPairEval[Color::W] && !$bishopPairEval[Color::B]) {
            foreach ($this->board->pieces() as $piece) {
                if ($piece->id === Piece::B) {
                    $this->result[$piece->color] += $this->countBlockingPawns(
                        $piece,
                        $this->board->square->color($piece->sq)
                    );
                }
            }
        }

        $this->explain($this->result);
    }

    private function countBlockingPawns(AbstractPiece $bishop, string $sqColor): int
    {
        $count = 0;
        foreach ($this->board->pieces() as $piece) {
            if ($piece->id === Piece::P) {
                if (
                    $piece->color === $bishop->color &&
                    $this->board->square->color($piece->sq) === $sqColor
                ) {
                    $count += 1;
                }
            }
        }

        return $count;
    }
}
