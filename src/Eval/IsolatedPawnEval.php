<?php

namespace Chess\Eval;

use Chess\Piece\P;
use Chess\Variant\Classical\PGN\AN\Piece;

class IsolatedPawnEval extends AbstractEval implements InverseEvalInterface
{
    const NAME = 'Isolated pawn';

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
}
