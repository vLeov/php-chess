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
        503,    // meterial
        401,    // king safety
        307,    // center
        211,    // attack
        101,    // connectivity
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
                $this->label[$color] += self::WEIGHTS[$key] * $val * 100;
            }
        }

        return $this->label;
    }
}
