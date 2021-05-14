<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;

/**
 * AbstractDecoder
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

    protected function label(Board $clone, string $color)
    {
        $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());
        $label = (new $this->labeller($sample, $weights))->label()[$color];

        return $label;
    }
}
