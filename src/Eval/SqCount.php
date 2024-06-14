<?php

namespace Chess\Eval;

use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;

class SqCount
{
    const TYPE_FREE      = 'free';
    const TYPE_USED      = 'used';

    private AbstractBoard $board;

    private $used = [];

    private $free = [];

    public function __construct(AbstractBoard $board)
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

        foreach ($this->board->pieces() as $piece) {
            $used[$piece->color][] = $piece->sq;
        }

        return (object) $used;
    }
}
