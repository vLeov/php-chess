<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Heuristic\LinearCombination;
use Chess\PGN\Symbol;

/**
 * LinearCombination labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationLabeller
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

        $this->weights = LinearCombination::WEIGHTS;
    }

    public function label(): array
    {
        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $this->weights[$key] * $val;
            }
        }

        return $this->label;
    }
}
