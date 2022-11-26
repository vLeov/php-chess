<?php

namespace Chess\Player;

use Chess\Exception\PlayerException;
use Chess\Variant\Classical\Board;
use Chess\Movetext;

/**
 * PgnPlayer.
 *
 * Plays a chess game in PGN format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PgnPlayer
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $board;

    /**
     * Moves.
     *
     * @var array
     */
    protected array $moves;

    /**
     * History.
     *
     * @var array
     */
    protected array $history;

    /**
     * Constructor.
     *
     * @param string $text
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(string $text, Board $board = null)
    {
        $movetext = (new Movetext($text))->validate();
        $board ? $this->board = $board : $this->board = new Board();
        $this->moves = (new Movetext($movetext))->getMovetext()->moves;
        $this->history = [array_values((new Board())->toAsciiArray())];
    }

    /**
     * Returns the resulting board object of playing a game.
     *
     * @return \Chess\Variant\Classical\Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Returns the moves as an array.
     *
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * Returns the history.
     *
     * @return array
     */
    public function getHistory(): array
    {
        return $this->history;
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
