<?php

namespace Chess\Play;

use Chess\Variant\AbstractBoard;

abstract class AbstractPlay
{
    protected AbstractBoard $initialBoard;

    protected AbstractBoard $board;

    protected array $fen;

    public function getBoard(): AbstractBoard
    {
        return $this->board;
    }

    public function getFen(): array
    {
        return $this->fen;
    }

    abstract public function validate(): AbstractPlay;
}
