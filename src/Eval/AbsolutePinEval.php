<?php

namespace Chess\Eval;

use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

class AbsolutePinEval extends AbstractEval implements InverseEvalInterface
{
    const NAME = 'Absolute pin';

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K) {
                $clone = unserialize(serialize($this->board));
                $clone->detach($clone->getPieceBySq($piece->getSq()));
                $clone->refresh();
                $newCheckingPieces = $clone->checkingPieces();
                if (count($newCheckingPieces) > count($this->board->checkingPieces())) {
                    $this->result[$piece->getColor()] += self::$value[$piece->getId()];
                    $this->explain($piece);
                }
            }
        }
    }

    private function explain($subject, $target = null)
    {
        $this->explanation[] = "{$subject->getId()} on {$subject->getSq()} is pinned.";

        return $this->explanation;
    }
}
