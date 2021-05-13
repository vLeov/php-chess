<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Heuristic\Picture\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

/**
 * OptimalLinearCombinationLabeller
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class OptimalLinearCombinationLabeller implements LabellerInterface
{
    private $heuristicPicture;

    private $sample;

    private $permutations;

    private $label;

    public function __construct(
        AbstractHeuristicPicture $heuristicPicture,
        array $sample = [],
        array $permutations = []
    )
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->sample = $sample;

        $this->permutations = $permutations;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        $labels = [];
        foreach ($this->permutations as $weights) {
            $label = $this->label;
            foreach ($this->sample as $color => $arr) {
                foreach ($arr as $key => $val) {
                    $label[$color] += $weights[$key] * $val;
                }
                $label[$color] = round($label[$color], 2);
            }
            $labels[] = $label;
        }

        foreach ($labels as $key => $label) {
            if ($label[Symbol::WHITE] > $this->label[Symbol::WHITE]) {
                $this->label[Symbol::WHITE] = $label[Symbol::WHITE];
            }
            if ($label[Symbol::BLACK] > $this->label[Symbol::BLACK]) {
                $this->label[Symbol::BLACK] = $label[Symbol::BLACK];
            }
        }

        return $this->label;
    }
}
