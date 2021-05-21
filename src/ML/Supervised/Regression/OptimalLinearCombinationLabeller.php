<?php

namespace Chess\ML\Supervised\Regression;

use Chess\PGN\Symbol;

/**
 * OptimalLinearCombinationLabeller
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class OptimalLinearCombinationLabeller implements LabellerInterface
{
    private $sample;

    private $permutations;

    private $label;

    private $balance;

    public function __construct(array $sample = [], array $permutations = [])
    {
        $this->sample = $sample;

        $this->permutations = $permutations;

        $this->label = $this->balance = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        foreach ($this->permutations as $weights) {
            $label = [
                Symbol::WHITE => 0,
                Symbol::BLACK => 0,
            ];
            foreach ($this->sample as $color => $arr) {
                foreach ($arr as $key => $val) {
                    $label[$color] += $weights[$key] * $val;
                }
                $label[$color] = round($label[$color], 2);
                $label[$color] > $this->label[$color] ? $this->label[$color] = $label[$color] : null;
            }
        }

        return $this->label;
    }

    public function balance(): array
    {
        $base = [];
        foreach ($this->sample[Symbol::WHITE] as $key => $val) {
            $base[$key] = $this->sample[Symbol::WHITE][$key] - $this->sample[Symbol::BLACK][$key];
        }
        foreach ($this->permutations as $weights) {
            $balance = 0;
            foreach ($base as $key => $val) {
                $balance += $weights[$key] * $val;
            }
            $balance = round($balance, 2);
            $balance > $this->balance[Symbol::WHITE] ? $this->balance[Symbol::WHITE] = $balance : null;
            $balance < $this->balance[Symbol::BLACK] ? $this->balance[Symbol::BLACK] = $balance : null;
        }

        return $this->balance;
    }

    public function permute(string $color, float $label): ?array
    {
        foreach ($this->permutations as $weights) {
            $sum = 0;
            foreach ($this->sample[$color] as $key => $val) {
                $sum += $weights[$key] * $val;
            }
            if (round($sum, 2) === $label) {
                return $weights;
            }
        }

        return null;
    }
}
