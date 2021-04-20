<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\PGN\Symbol;

class BinaryLabeller
{
    private $sample;

    private $label;

    public function __construct($sample)
    {
        $this->sample = $sample;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        $this->sample[Symbol::WHITE] = array_reverse($this->sample[Symbol::WHITE]);
        $this->sample[Symbol::BLACK] = array_reverse($this->sample[Symbol::BLACK]);

        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $val * (2 ** $key);
            }
        }

        return $this->label;
    }
}
