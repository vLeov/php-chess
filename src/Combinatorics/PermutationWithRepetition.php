<?php

namespace Chess\Combinatorics;

/**
 * Permutations with repetitions.
 *
 * @link https://rosettacode.org/wiki/Permutations_with_repetitions#PHP
 */
class PermutationWithRepetition
{
    public function get($values, $size)
    {
        $a = [];
        $c = pow(count($values), $size);

        for ($i = 0; $i < $c; $i++) {
            $a[$i] = $this->permutate($values, $size, $i);
        }

        return $a;
    }

    private function permutate($values, $size, $offset)
    {
        $count = count($values);
        $array = [];

        for ($i = 0; $i < $size; $i++) {
            $selector = ($offset / pow($count,$i)) % $count;
            $array[$i] = $values[$selector];
        }

        return $array;
    }
}
