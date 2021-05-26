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
            $current = 0;
            foreach ($end as $j => $val) {
                $current += $weights[$j] * $val;
            }
            $sums[$i] = round($current, 2);
        }

        return [
            Symbol::WHITE => array_search(max($sums), $sums),
            Symbol::BLACK => array_search(min($sums), $sums),
        ];
    }
}
