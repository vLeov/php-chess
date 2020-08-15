<?php

namespace PGNChess\ML\Supervised\Regression\Labeller\Primes;

use PGNChess\PGN\Symbol;

/**
 * Primes labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Labeller
{
    const WEIGHTS = [
        2,      // attack
        3,      // connectivity
        5,      // center
        7,      // attacked
        11,     // king safety
        13,     // material
        17,     // piece capture event
        19      // check event
    ];

    private $sample;

    private $label;

    public function __construct($sample)
    {
        $this->sample = $sample;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += self::WEIGHTS[$key] * $val;
            }
        }

        return $this->label;
    }
}
