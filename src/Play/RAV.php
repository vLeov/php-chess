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
     * RAV movetext.
     *
     * @var array
     */
    protected RavMovetext $san;

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
        $this->rav = new RavMovetext($this->board->getMove(), $movetext);

        $this->rav->validate();
    }

    /**
     * Plays a RAV movetext.
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
