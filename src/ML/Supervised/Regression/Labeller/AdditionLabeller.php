<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\AbstractPicture;
use Chess\Heuristic\Picture\Addition as AdditionHeuristicPicture;
use Chess\PGN\Symbol;

/**
 * Addition labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class AdditionLabeller
{
    private $heuristicPicture;

    private $label;

    public function __construct(AbstractPicture $heuristicPicture)
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        foreach ($this->heuristicPicture->sample() as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $val;
            }
        }

        return $this->label;
    }
}
