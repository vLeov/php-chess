<?php

namespace Chess\Play;

use Chess\Exception\PlayException;
use Chess\Movetext\RAV as RavMovetext;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * Recursive Annotation Variation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class RAV extends AbstractPlay
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
        $rav = new RavMovetext($this->board->getMove(), $movetext);
        $rav->validate();
        $this->moves = $rav->getMoves();
    }

    /**
     * Plays a chess game.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\RAV
     */
    public function play(): RAV
    {
        // TODO

        return $this;
    }
}
