<?php

namespace PGNChess;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\PGN\Validate;

/**
 * Allows to play a chess game in the form of a PGN movetext.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Player
{
    protected $board;

    protected $moves;

    public function __construct(string $movetext)
    {
        $this->board = new Board;
        $this->moves = $this->extract($this->filter($movetext));
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function getMoves()
    {
        return $this->moves;
    }

    protected function extract(string $movetext)
    {
        $moves = [];
        $pairs = array_filter(preg_split('/[0-9]+\./', $movetext));
        foreach ($pairs as $pair) {
            $moves[] = array_values(array_filter(explode(' ', $pair)));
        }

        return $moves;
    }

    protected function filter(string $movetext)
    {
        $movetext = str_replace(
            [
                Symbol::RESULT_WHITE_WINS,
                Symbol::RESULT_BLACK_WINS,
                Symbol::RESULT_DRAW,
                Symbol::RESULT_UNKNOWN,
            ],
            '',
            Validate::movetext($movetext)
        );

        return $movetext;
    }
}
