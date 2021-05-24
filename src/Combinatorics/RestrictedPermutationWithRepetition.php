<?php

namespace Chess\Combinatorics;

/**
 * Permutations with repetitions.
 *
 * @link https://rosettacode.org/wiki/Permutations_with_repetitions#PHP
 */
class RestrictedPermutationWithRepetition extends AbstractPermutation
{
    public function get($values, $size, $sum): array
    {
        $a = [];
        $c = pow(count($values), $size);

        for ($i = 0; $i < $c; $i++) {
            $permutation = $this->permutate($values, $size, $i);
            if ($sum === array_sum($permutation)) {
                $a[$i] = $permutation;
            }
        }

        return array_values($a);
    }
}
