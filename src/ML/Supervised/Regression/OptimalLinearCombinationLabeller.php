<?php

namespace Chess\ML\Supervised\Regression;

use Chess\PGN\Symbol;

/**
 * OptimalLinearCombinationLabeller
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class OptimalLinearCombinationLabeller
{
    const INIT = [
        Symbol::WHITE => 0,
        Symbol::BLACK => 0,
    ];

    private $permutations;

    public function __construct(array $permutations = [])
    {
        $this->permutations = $permutations;
    }

    public function label(array $sample): array
    {
        $label = self::INIT;
        foreach ($this->permutations as $weights) {
            $current = self::INIT;
            foreach ($sample as $color => $arr) {
                foreach ($arr as $key => $val) {
                    $current[$color] += $weights[$key] * $val;
                }
                $current[$color] = round($current[$color], 2);
                $current[$color] > $label[$color] ? $label[$color] = $current[$color] : null;
            }
        }

        return $label;
    }

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

    public function permute(array $sample, string $color, float $label): ?array
    {
        foreach ($this->permutations as $weights) {
            $sum = 0;
            foreach ($sample[$color] as $key => $val) {
                $sum += $weights[$key] * $val;
            }
            if (round($sum, 2) === $label) {
                return $weights;
            }
        }

        return null;
    }
}
