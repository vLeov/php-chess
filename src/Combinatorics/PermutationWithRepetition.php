<?php

namespace Chess\Combinatorics;

/**
 * Permutations with repetitions.
 *
 * @link https://rosettacode.org/wiki/Permutations_with_repetitions#PHP
 */
class PermutationWithRepetition extends AbstractPermutation
{
    public function get($values, $size): array
    {
        $a = [];
        $c = pow(count($values), $size);

        for ($i = 0; $i < $c; $i++) {
            $a[$i] = $this->permutate($values, $size, $i);
        }

        return $a;
    }
}
