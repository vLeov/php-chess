<?php

namespace Chess\Eval;

use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class DoubledPawnEval extends AbstractEval implements InverseEvalInterface
{
    const NAME = 'Doubled pawn';

    protected array $phrase = [
        Color::W => [
            [
                'diff' => 4,
                'meaning' => "The white pieces are totally better in terms of doubled pawns.",
            ],
            [
                'diff' => 3,
                'meaning' => "The white pieces are remarkably better in terms of doubled pawns.",
            ],
            [
                'diff' => 2,
                'meaning' => "The white pieces are somewhat better in terms of doubled pawns.",
            ],
            [
                'diff' => 1,
                'meaning' => "The white pieces are slightly better in terms of doubled pawns.",
            ],
        ],
        Color::B => [
            [
                'diff' => -4,
                'meaning' => "The black pieces are totally better in terms of doubled pawns.",
            ],
            [
                'diff' => -3,
                'meaning' => "The black pieces are remarkably better in terms of doubled pawns.",
            ],
            [
                'diff' => -2,
                'meaning' => "The black pieces are somewhat better in terms of doubled pawns.",
            ],
            [
                'diff' => -1,
                'meaning' => "The black pieces are slightly better in terms of doubled pawns.",
            ],
        ],
    ];

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->getPieces() as $piece) {
            $color = $piece->getColor();
            if ($piece->getId() === Piece::P) {
                $file = $piece->getSqFile();
                $ranks = $piece->getRanks();
                if ($nextPiece = $this->board->getPieceBySq($file.$ranks->next)) {
                    if ($nextPiece->getId() === Piece::P && $nextPiece->getColor() === $color) {
                        $this->result[$color] += 1;
                    }
                }
            }
        }

        $this->explain($this->result);
    }

    private function explain(array $result): void
    {
        if ($sentence = $this->sentence($result)) {
            $this->phrases[] = $sentence;
        }
    }
}
