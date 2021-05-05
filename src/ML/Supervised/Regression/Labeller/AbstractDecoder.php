<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Board;

/**
 * Abstract decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class AbstractDecoder
{
    protected $board;

    protected $labeller;

    protected $heuristicPicture;

    protected $result = [];

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    protected function closest(float $search)
    {
        $closest = [];
        foreach ($this->result as $key => $val) {
            $closest[$key] = abs(current($val) - $search);
        }
        asort($closest);

        return current($this->result[array_key_first($closest)]);
    }

    protected function pgn(float $search)
    {
        foreach ($this->result as $key => $val) {
            if ($search === current($val)) {
                return key($val);
            }
        }
    }
}
