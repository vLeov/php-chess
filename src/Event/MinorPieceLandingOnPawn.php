<?php

namespace PGNChess\Event;

use PGNChess\PGN\Symbol;

/**
 * Minor piece landing on pawn.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class MinorPieceLandingOnPawn extends AbstractEvent
{
    const NAME = 'minor_piece_landing_on_pawn';

    public function capture(string $color): int
    {
        if ($this->board->getHistory()) {
            $last = array_slice($this->board->getHistory(), -1)[0];
            if ($last->move->color === Symbol::oppColor($color)) {
                foreach ($this->board->getPiecesByColor($color) as $piece) {
                    if ($piece->getIdentity() === Symbol::PAWN) {
                        foreach ($piece->getCaptureSquares() as $square) {
                            if ($target = $this->board->getPieceByPosition($square)) {
                                switch ($target->getIdentity()) {
                                    case Symbol::BISHOP:
                                        return 1;
                                    case Symbol::KNIGHT:
                                        return 1;
                                }
                            }
                        }
                    }
                }
            }
        }

        return 0;
    }
}
