<?php

namespace Chess\Computer;

use Chess\Variant\Classical\Board;

/**
 * AbstractMove
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
abstract class AbstractMove
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $board;

    /**
     * Returns a chess move.
     *
     * @return null|object
     */
    abstract public function move(): ?object;
}
