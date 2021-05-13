<?php

namespace Chess\ML\Supervised\Regression;

use Chess\PGN\Symbol;

/**
 * LinearCombination labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationLabeller implements LabellerInterface
{
    private $sample;

    private $weights;

    private $label;

    public function __construct(array $sample = [], array $weights = [])
    {
        $this->sample = $sample;

        $this->weights = $weights;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $this->weights[$key] * $val;
            }
            $this->label[$color] = round($this->label[$color], 2);
        }

        return $this->label;
    }
}
