<?php

namespace Chess\Play;

use Chess\Exception\PlayException;
use Chess\Movetext\SAN as SanMovetext;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * Standard Algebraic Notation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class SAN extends AbstractPlay
{
    /**
     * Constructor.
     *
     * @param string $movetext
     * @param ClassicalBoard $board
     */
    public function __construct(string $movetext, ClassicalBoard $board = null)
    {
        $this->board = $board ?? new ClassicalBoard();
        $this->fen = [$this->board->toFen()];
        $san = new SanMovetext($this->board->getMove(), $movetext);
        $san->validate();
        $this->moves = $san->getMoves();
    }

    /**
     * Plays a chess game.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\SAN
     */
    public function play(): SAN
    {
        foreach ($this->moves as $key => $val) {
            if (!$this->board->play($this->board->getTurn(), $val)) {
                throw new PlayException();
            }
            $this->fen[] = $this->board->toFen();
        }

        return $this;
    }
}
