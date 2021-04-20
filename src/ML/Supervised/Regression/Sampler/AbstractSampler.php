<?php

namespace Chess\ML\Supervised\Regression\Sampler;

use Chess\Board;
use Chess\PGN\Symbol;

abstract class AbstractSampler
{
    protected $board;

    protected $sample;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->sample = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function setBoard(Board $board)
    {
        $this->board = $board;

        return $this;
    }

    abstract public function sample(): array;
}
