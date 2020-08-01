<?php

namespace PGNChess\ML\Supervised\Regression\Labeller\Primes;

use PGNChess\PGN\Symbol;

/**
 * Primes labeller.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Labeller
{
    /**
     * Order is: attack, connectivity, center, king safety, material and check.
     */
    const WEIGHTS = [ 2, 3, 5, 7, 11, 13 ];

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
