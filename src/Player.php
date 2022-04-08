<?php

namespace Chess;

use Chess\Board;
use Chess\Exception\PlayerException;
use Chess\PGN\Symbol;
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
    protected $board;

    /**
     * Moves.
     *
     * @var array
     */
    protected $moves;

    public function __construct(string $movetext, Board $board = null)
    {
        $movetext = (new Movetext($movetext))->validate();
        $board ? $this->board = $board : $this->board = new Board();
        $this->moves = (new Movetext($this->filter($movetext)))
            ->getOrder()->move;
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

    /**
     * Removes a bunch of tags from the given movetext.
     *
     * @param string $movetext
     * @return string
     */
    protected function filter(string $movetext): string
    {
        $filter = str_replace(
            [
                Symbol::RESULT_WHITE_WINS,
                Symbol::RESULT_BLACK_WINS,
                Symbol::RESULT_DRAW,
                Symbol::RESULT_UNKNOWN,
            ],
            '',
            $movetext
        );

        return $filter;
    }
}
