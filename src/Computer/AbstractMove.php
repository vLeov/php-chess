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
     * Returns a chess move.
     *
     * @param \Chess\Variant\Classical\Board $board
     * @return null|object
     */
    abstract public function move(Board $board): ?object;
}
