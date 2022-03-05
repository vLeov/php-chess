<?php

namespace Chess;

use Chess\PGN\Symbol;

/**
 * Abstract snapshot.
 *
 * A so-called snapshot is intended to capture a particular feature of a chess game
 * mainly for the purpose of being plotted on a chart for further visual study.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
abstract class AbstractSnapshot extends Player
{
    protected $snapshot = [];

    abstract public function take(): array;

    /**
     * Scales the snapshot to have values between 0 and 1.
     */
    protected function normalize()
    {
        $values = array_merge(
            array_column($this->snapshot, Symbol::WHITE),
            array_column($this->snapshot, Symbol::BLACK)
        );

        if ($values) {
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
}
