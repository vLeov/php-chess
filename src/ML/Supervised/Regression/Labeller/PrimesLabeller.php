<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Heuristic\Picture\LinearCombination as LinearCombinationHeuristicPicture;
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

        $this->weights = LinearCombinationHeuristicPicture::WEIGHTS;
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
