<?php

namespace Chess;

use Chess\Exception\PlayerException;
use Chess\PGN\Movetext;

/**
 * Player.
 *
 * Plays a chess game in PGN format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Player
{
    /**
     * Chess board.
     *
     * @var \Chess\Board
     */
    protected Board $board;

    /**
     * Moves.
     *
     * @var array
     */
    protected array $moves;

    public function __construct(string $text, Board $board = null)
    {
        $movetext = (new Movetext($text))->validate();

        $board ? $this->board = $board : $this->board = new Board();

        $this->moves = (new Movetext($movetext))->getMovetext()->moves;
    }

    /**
     * Returns the resulting `Chess\Board` object of playing a game.
     *
     * @return \Chess\Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Returns the moves.
     *
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * Plays a chess game.
     *
     * @return \Chess\Player
     */
    public function play(): Player
    {
        foreach ($this->moves as $key => $val) {
            if ($key % 2 === 0) {
                if (!$this->board->play('w', $val)) {
                    throw new PlayerException;
                }
            } else {
                if (!$this->board->play('b', $val)) {
                    throw new PlayerException;
                }
            }
        }

        return $this;
    }
}
