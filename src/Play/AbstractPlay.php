<?php

namespace Chess\Play;

use Chess\Variant\Classical\Board;

abstract class AbstractPlay
{
    protected Board $initialBoard;

    protected Board $board;

    protected array $fen;

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getFen(): array
    {
        return $this->fen;
    }

    abstract public function validate(): AbstractPlay;
}
