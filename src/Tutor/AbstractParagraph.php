<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board;

abstract class AbstractParagraph
{
    protected Board $board;

    protected array $paragraph = [];

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getParagraph(): array
    {
        return $this->paragraph;
    }
}
