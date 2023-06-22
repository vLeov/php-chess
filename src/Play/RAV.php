<?php

namespace Chess\Play;

use Chess\Exception\PlayException;
use Chess\Movetext\RAV as RavMovetext;
use Chess\Variant\Capablanca\Board as CapablancaBoard;
use Chess\Variant\Capablanca\PGN\Move as CapablancaPgnMove;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\PGN\Move as ClassicalPgnMove;

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

        if (is_a($board, CapablancaBoard::class)) {
            $rav = new RavMovetext(new CapablancaPgnMove(), $movetext);
        } else {
            $rav = new RavMovetext(new ClassicalPgnMove(), $movetext);
        }

        $rav->validate();

        $this->moves = $rav->getMoves();
        $this->fen = [(new ClassicalBoard())->toFen()];
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
