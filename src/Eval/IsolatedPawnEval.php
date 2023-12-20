<?php

namespace Chess\Eval;

use Chess\Piece\P;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class IsolatedPawnEval extends AbstractEval implements InverseEvalInterface
{
    const NAME = 'Isolated pawn';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::P) {
                if ($this->isIsolatedPawn($piece)) {
                    $this->result[$piece->getColor()][] = $piece->getSq();
                }
            }
        }

        $this->explain($this->result);
    }

    private function isIsolatedPawn(P $pawn): int
    {
        $color = $pawn->getColor();
        $pawnFile = $pawn->getSqFile();

        $prevFile = chr(ord($pawnFile) - 1);
        $nextFile = chr(ord($pawnFile) + 1);

        $sqs = [];
        foreach ([ $prevFile, $nextFile ] as $file) {
            if ($file < 'a' || $file > 'h') {
                continue;
            }
            $ranks = range(2, 7);
            $sqsFile = array_map(function($rank) use ($file){
                return $file . $rank;
            }, $ranks);
            $sqs = [...$sqs, ...$sqsFile];
        }

        foreach ($sqs as $sq) {
            if ($nextPiece = $this->board->getPieceBySq($sq)) {
                if ($nextPiece->getId() === Piece::P && $nextPiece->getColor() === $color) {
                    return 0;
                }
            }
        }

        return 1;
    }

    private function explain(array $result): void
    {
        $singular = mb_strtolower('an ' . self::NAME);
        $plural = mb_strtolower(self::NAME.'s');

        $this->shorten($result, $singular, $plural);
    }
}
