<?php

namespace Chess\ML\Supervised\Regression;

use Chess\PGN\Symbol;

/**
 * OptimalLinearCombinationLabeller
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class OptimalLinearCombinationLabeller implements LabellerInterface
{
    private $sample;

    private $permutations;

    private $label;

    public function __construct(array $sample = [], array $permutations = [])
    {
        $this->sample = $sample;

        $this->permutations = $permutations;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        foreach ($this->permutations as $weights) {
            $label = [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ];
            foreach ($this->sample as $color => $arr) {
                foreach ($arr as $key => $val) {
                    $label[$color] += $weights[$key] * $val;
                }
                $label[$color] = round($label[$color], 2);
                $label[$color] > $this->label[$color] ? $this->label[$color] = $label[$color] : null;
            }
        }

        return $this->label;
    }
}
