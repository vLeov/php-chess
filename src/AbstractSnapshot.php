<?php

namespace PGNChess;

use PGNChess\PGN\Symbol;

/**
 * Snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
abstract class AbstractSnapshot extends Player
{
    protected $snapshot = [];

    abstract public function take(): array;

    protected function normalize()
    {
        $values = array_merge(
            array_column($this->snapshot, Symbol::WHITE),
            array_column($this->snapshot, Symbol::BLACK)
        );

        $min = min($values);
        $max = max($values);

        if ($max - $min > 0) {
            foreach ($this->snapshot as $key => $val) {
                $this->snapshot[$key][Symbol::WHITE] = round(($val[Symbol::WHITE] - $min) / ($max - $min), 2);
                $this->snapshot[$key][Symbol::BLACK] = round(($val[Symbol::BLACK] - $min) / ($max - $min), 2);
            }
        }
    }
}
