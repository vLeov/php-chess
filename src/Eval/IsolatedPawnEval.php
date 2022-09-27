<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\Piece\P;

class IsolatedPawnEval extends AbstractEval implements InverseEvalInterface
{
    const NAME = 'Isolated pawn';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            $color = $piece->getColor();
            if ($piece->getId() === Piece::P) {
                $this->result[ $color ] += $this->checkIsolatedPawn($piece);
            }
        }
        return $this->result;
    }

    private function checkIsolatedPawn(P $pawn): int
    {
        $color = $pawn->getColor();
        $pawnFile = $pawn->getFile();

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
}
