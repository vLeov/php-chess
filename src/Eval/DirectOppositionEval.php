<?php

namespace Chess\Eval;

use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class DirectOppositionEval extends AbstractEval implements TernaryEvalInterface
{
    const NAME = 'Direct opposition';

    protected array $phrase = [
        Color::W => [
            [
                'diff' => 1,
                'meaning' => "The white king has the direct opposition preventing the advance of the other king.",
            ],
        ],
        Color::B => [
            [
                'diff' => -1,
                'meaning' => "The black king has the direct opposition preventing the advance of the other king.",
            ],
        ],
    ];

    public function __construct(Board $board)
    {
        $this->board = $board;

        $wKSq = $this->board->getPiece(Color::W, Piece::K)->getSq();
        $bKSq = $this->board->getPiece(Color::B, Piece::K)->getSq();

        if ($wKSq[0] === $bKSq[0]) {
            if (abs($wKSq[1] - $bKSq[1]) === 2) {
                $this->result = [
                    Color::W => (int) ($this->board->getTurn() !== Color::W),
                    Color::B => (int) ($this->board->getTurn() !== Color::B),
                ];
            }
        } elseif ($wKSq[1] === $bKSq[1]) {
            if (abs(ord($wKSq[0]) - ord($bKSq[0])) === 2) {
                $this->result = [
                    Color::W => (int) ($this->board->getTurn() !== Color::W),
                    Color::B => (int) ($this->board->getTurn() !== Color::B),
                ];
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
