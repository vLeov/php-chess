<?php

namespace PGNChess\Event;

use PGNChess\PGN\Symbol;

/**
 * Pawn threatening minor piece.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PawnThreateningMinorPiece extends AbstractEvent
{
    public function capture(string $color): int
    {
        if ($this->board->getHistory()) {
            $last = array_slice($this->board->getHistory(), -1)[0];
            if ($last->move->color === $color && $last->move->identity === Symbol::PAWN) {
                $pawn = $this->board->getPieceByPosition($last->move->position->next);
                foreach ($pawn->getCaptureSquares() as $square) {
                    if ($piece = $this->board->getPieceByPosition($square)) {
                        switch (true) {
                            case Symbol::oppColor($piece->getColor()) && $piece->getIdentity() === Symbol::BISHOP:
                                return 1;
                            case Symbol::oppColor($piece->getColor()) && $piece->getIdentity() === Symbol::KNIGHT:
                                return 1;
                        }
                    }
                }
            }
        }

        return 0;
    }
}
