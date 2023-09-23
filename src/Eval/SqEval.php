<?php

namespace Chess\Eval;

use Chess\Piece\AsciiArray;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

/**
 * Square evaluation.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class SqEval extends AbstractEval
{
    const NAME           = 'Square';

    const TYPE_FREE      = 'free';
    const TYPE_USED      = 'used';

    private $used = [];

    private $free = [];

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->used = $this->used();
        $this->free = $this->free();
    }

    public function eval(): object
    {
        return (object) [
            self::TYPE_FREE => $this->free,
            self::TYPE_USED => (object) $this->used,
        ];
    }

    /**
     * All squares.
     *
     * @return array
     */
    private function all(): array
    {
        $all = [];
        for ($i = 0; $i < $this->board->getSize()['files']; $i++) {
            for ($j = 0; $j < $this->board->getSize()['ranks']; $j++) {
                $all[] = AsciiArray::fromIndexToAlgebraic($i, $j);
            }
        }

        return $all;
    }

    /**
     * Free squares.
     *
     * @return array
     */
    private function free(): array
    {
        return array_diff($this->all(), [...$this->used[Color::W], ...$this->used[Color::B]]);
    }

    /**
     * Squares used by both players.
     *
     * @return array
     */
    private function used(): array
    {
        $used = [];
        foreach ($this->board->getPieces() as $piece) {
            $used[$piece->getColor()][] = $piece->getSq();
        }

        return $used;
    }
}
