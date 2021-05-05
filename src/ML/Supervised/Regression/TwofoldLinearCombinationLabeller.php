<?php

namespace Chess\ML\Supervised\Regression;

use Chess\AbstractPicture;
use Chess\Heuristic\LinearCombinationEvaluation;
use Chess\PGN\Symbol;

/**
 * TwofoldLinearCombination labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class TwofoldLinearCombinationLabeller implements LabellerInterface
{
    private $heuristicPicture;

    private $sample;

    private $label;

    private $weights;

    public function __construct(AbstractPicture $heuristicPicture, array $sample = [])
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->sample = $sample;

        $this->label = 0;

        $this->weights = (new LinearCombinationEvaluation($heuristicPicture))->getWeights();
    }

    public function label(): float
    {
        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $color === Symbol::WHITE
                    ? $this->label += $this->weights[$key] * $val
                    : $this->label -= $this->weights[$key] * $val;
            }
        }

        return round($this->label, 2);
    }
}
