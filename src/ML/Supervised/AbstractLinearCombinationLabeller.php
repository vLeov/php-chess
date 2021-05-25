<?php

namespace Chess\ML\Supervised;

use Chess\PGN\Symbol;

abstract class AbstractLinearCombinationLabeller
{
    const INIT = [
        Symbol::WHITE => 0,
        Symbol::BLACK => 0,
    ];

    protected $permutations;

    public function __construct(array $permutations = [])
    {
        $this->permutations = $permutations;
    }

    abstract public function label(array $end): array;

    public function balance(array $base = []): array
    {
        $balance = self::INIT;
        foreach ($this->permutations as $weights) {
            $current = 0;
            foreach ($base as $key => $val) {
                $current += $weights[$key] * $val;
            }
            $current = round($current, 2);
            $current > $balance[Symbol::WHITE] ? $balance[Symbol::WHITE] = $current : null;
            $current < $balance[Symbol::BLACK] ? $balance[Symbol::BLACK] = $current : null;
        }

        return $balance;
    }

    public function extractPermutation(array $end, string $color, float $label): ?array
    {
        foreach ($this->permutations as $weights) {
            $sum = 0;
            foreach ($end[$color] as $key => $val) {
                $sum += $weights[$key] * $val;
            }
            if (round($sum, 2) === $label) {
                return $weights;
            }
        }

        return null;
    }

    public function guessPermutations(array $end, string $color): array
    {
        $guesses = [];
        foreach ($this->permutations as $i => $weights) {
            $sum = 0;
            foreach ($end as $j => $val) {
                $sum += $weights[$j] * $val;
            }
            $guesses[] = [
                'n' => $i,
                'eval' => round($sum, 2),
                'weights' => $weights,
            ];
        }
        if ($color === Symbol::WHITE) {
            array_multisort(array_column($guesses, 'eval'), SORT_DESC, $guesses);
        } else {
            array_multisort(array_column($guesses, 'eval'), SORT_ASC, $guesses);
        }

        return $guesses;
    }
}
