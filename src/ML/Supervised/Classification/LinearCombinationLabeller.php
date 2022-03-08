<?php

namespace Chess\ML\Supervised\Classification;

use Chess\ML\Supervised\AbstractLinearCombinationLabeller;
use Chess\PGN\Symbol;

/**
 * LinearCombinationLabeller
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationLabeller extends AbstractLinearCombinationLabeller
{
    public function label(array $end): array
    {
        $sums = [];
        foreach ($this->permutations as $i => $weights) {
            $sum = 0;
            foreach ($end as $j => $val) {
                $sum += $weights[$j] * $val;
            }
            $sums[$i] = round($sum, 2);
        }

        $max = array_search(max($sums), $sums);
        $min = array_search(min($sums), $sums);

        return [
            Symbol::WHITE => $max,
            Symbol::BLACK => $min,
        ];
    }
}
