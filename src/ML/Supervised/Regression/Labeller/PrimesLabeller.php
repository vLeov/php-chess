<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Event\Picture\Basic as BasicEventPicture;
use Chess\Heuristic\Picture\Weighted as WeightedHeuristicPicture;
use Chess\PGN\Symbol;

/**
 * Primes labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PrimesLabeller
{
    private $sample;

    private $label;

    private $weights;

    public function __construct($sample)
    {
        $this->sample = $sample;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $this->weights = array_merge(
            array_fill(0, BasicEventPicture::N_DIMENSIONS, 0),
            WeightedHeuristicPicture::WEIGHTS
        );
    }

    public function label(): array
    {
        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $this->weights[$key] * $val * 100;
            }
        }

        return $this->label;
    }
}
