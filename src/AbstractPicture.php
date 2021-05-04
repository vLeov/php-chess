<?php

namespace Chess;

use Chess\PGN\Symbol;

abstract class AbstractPicture extends Player
{
    protected $dimensions;

    protected $picture = [];

    abstract public function take(): array;

    public function getDimensions()
    {
        return $this->dimensions;
    }

    protected function normalize()
    {
        $normalization = [];

        if (count($this->board->getHistory()) >= 2) {
            for ($i = 0; $i < count($this->dimensions); $i++) {
                $values = array_merge(
                    array_column($this->picture[Symbol::WHITE], $i),
                    array_column($this->picture[Symbol::BLACK], $i)
                );
                $min = min($values);
                $max = max($values);
                for ($j = 0; $j < count($this->picture[Symbol::WHITE]); $j++) {
                    if ($max - $min > 0) {
                        $normalization[Symbol::WHITE][$j][$i] = round(($this->picture[Symbol::WHITE][$j][$i] - $min) / ($max - $min), 2);
                        $normalization[Symbol::BLACK][$j][$i] = round(($this->picture[Symbol::BLACK][$j][$i] - $min) / ($max - $min), 2);
                    } elseif ($max == $min) {
                        $normalization[Symbol::WHITE][$j][$i] = round(1 / count($values), 2);
                        $normalization[Symbol::BLACK][$j][$i] = round(1 / count($values), 2);
                    }
                }
            }
        } else {
            $normalization[Symbol::WHITE][] = $normalization[Symbol::BLACK][] = array_fill(0, count($this->dimensions), 0.5);
        }

        $this->picture = $normalization;
    }
}
