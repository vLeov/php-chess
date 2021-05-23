<?php

namespace Chess\ML\Supervised;

use Chess\Board;

/**
 * AbstractDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
abstract class AbstractDecoder
{
    protected $board;

    protected $result = [];

    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
