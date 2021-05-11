<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Heuristic\LinearCombinationEvaluation;
use Chess\Heuristic\Picture\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

/**
 * LinearCombination labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationLabeller implements LabellerInterface
{
    private $heuristicPicture;

    private $sample;

    private $label;

    public function __construct(AbstractHeuristicPicture $heuristicPicture, array $sample = [])
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->sample = $sample;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        $weights = array_values($this->heuristicPicture->getDimensions());

        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $weights[$key] * $val;
            }
            $this->label[$color] = round($this->label[$color], 2);
        }

        return $this->label;
    }
}
