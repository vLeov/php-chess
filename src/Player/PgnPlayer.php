<?php

namespace Chess\Player;

use Chess\Exception\PlayerException;
use Chess\Variant\Capablanca80\Board as Capablanca80Board;
use Chess\Variant\Capablanca80\PGN\Move as Capablanca80PgnMove;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\PGN\Move as ClassicalPgnMove;
use Chess\Movetext;

/**
 * PgnPlayer.
 *
 * Plays a chess game in PGN format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PgnPlayer extends AbstractPlayer
{
    /**
     * Constructor.
     *
     * @param string $text
     * @param ClassicalBoard $board
     */
    public function __construct(string $text, ClassicalBoard $board = null)
    {
        $board ? $this->board = $board : $this->board = new ClassicalBoard();

        if (is_a($board, Capablanca80Board::class)) {
            $movetext = new Movetext(new Capablanca80PgnMove(), $text);
        } else {
            $movetext = new Movetext(new ClassicalPgnMove(), $text);
        }

        $movetext->validate();

        $this->moves = $movetext->getMovetext()->moves;
        $this->history = [array_values((new ClassicalBoard())->toAsciiArray())];
    }

    /**
     * Plays a chess game.
     *
     * @return \Chess\Player\PgnPlayer
     */
    public function play(): PgnPlayer
    {
        foreach ($this->moves as $key => $val) {
            if ($key % 2 === 0) {
                if (!$this->board->play('w', $val)) {
                    throw new PlayerException();
                }
            } else {
                if (!$this->board->play('b', $val)) {
                    throw new PlayerException();
                }
            }
            $this->history[] = array_values($this->board->toAsciiArray());
        }

        return $this;
    }
}
