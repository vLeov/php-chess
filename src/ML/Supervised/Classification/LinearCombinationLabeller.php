<?php

namespace Chess\ML\Supervised\Classification;

use Chess\ML\Supervised\AbstractLinearCombinationLabeller;

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
        $label = self::INIT;
        foreach ($this->permutations as $i => $weights) {
            $current = self::INIT;
            foreach ($end as $color => $arr) {
                foreach ($arr as $key => $val) {
                    $current[$color] += $weights[$key] * $val;
                }
                $current[$color] = round($current[$color], 2);
                $current[$color] > $label[$color] ? $label[$color] = $i : null;
            }
        }

        return $label;
    }
}
