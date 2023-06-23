<?php

namespace Chess\Play;

use Chess\Exception\PlayException;
use Chess\Movetext\SAN as SanMovetext;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\PGN\Move;

/**
 * Standard Algebraic Notation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class SAN extends AbstractPlay
{
    /**
     * SAN movetext.
     *
     * @var array
     */
    protected SanMovetext $sanMovetext;

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
        $this->sanMovetext = new SanMovetext($this->board->getMove(), $movetext);

        $this->sanMovetext->validate();
    }

    /**
     * Plays a SAN movetext.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\SAN
     */
    public function play(): SAN
    {
        foreach ($this->sanMovetext->getMoves() as $key => $val) {
            if ($val !== Move::ELLIPSIS) {
                if (!$this->board->play($this->board->getTurn(), $val)) {
                    throw new PlayException();
                }
                $this->fen[] = $this->board->toFen();
            }
        }

        return $this;
    }
}
