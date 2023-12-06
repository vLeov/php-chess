<?php

namespace Chess\Eval;

use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class BishopPairEval extends AbstractEval implements TernaryEvalInterface
{
    const NAME = 'Bishop pair';

    protected array $phrase = [
        Color::W => [
            [
                'diff' => 1,
                'meaning' => "White has the bishop pair.",
            ],
        ],
        Color::B => [
            [
                'diff' => -1,
                'meaning' => "Black has the bishop pair.",
            ],
        ],
    ];

    public function __construct(Board $board)
    {
        $this->board = $board;

        $count = [
            Color::W => 0,
            Color::B => 0,
        ];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::B) {
                $count[$piece->getColor()] += 1;
            }
        }

        if ($count[Color::W] === 2 && $count[Color::W] > $count[Color::B]) {
            $this->result[Color::W] = 1;
        } elseif ($count[Color::B] === 2 && $count[Color::B] > $count[Color::W]) {
            $this->result[Color::B] = 1;
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
