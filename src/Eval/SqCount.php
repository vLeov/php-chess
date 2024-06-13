<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

class SqCount
{
    const TYPE_FREE      = 'free';
    const TYPE_USED      = 'used';

    private Board $board;

    private $used = [];

    private $free = [];

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->used = $this->used();
        $this->free = $this->free();
    }

    public function count(): object
    {
        return (object) [
            self::TYPE_FREE => $this->free,
            self::TYPE_USED => $this->used,
        ];
    }

    private function free(): array
    {
        return array_diff($this->board->square->all(), [...$this->used->{Color::W}, ...$this->used->{Color::B}]);
    }

    private function used(): object
    {
        $used = [
            Color::W => [],
            Color::B => [],
        ];

        foreach ($this->board->getPieces() as $piece) {
            $used[$piece->color][] = $piece->sq;
        }

        return (object) $used;
    }
}
