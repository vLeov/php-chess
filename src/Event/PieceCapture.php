<?php

namespace PGNChess\Event;

/**
 * Piece capture.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PieceCapture extends AbstractEvent
{
    const NAME = 'capture';

    public function capture(string $color): int
    {
        $last = array_slice($this->board->getHistory(), -1)[0];
        $this->result = (int) ($last->move->isCapture && $last->move->color === $color);

        return $this->result;
    }
}
