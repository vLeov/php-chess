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

    public function eval($feature): ?array
    {
        switch ($feature) {
            case self::TYPE_FREE:
                return $this->free();
            case self::TYPE_USED:
                return $this->used();
        }

        return null;
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
        $used = $this->used();

        return array_diff($this->all(), [...$used[Color::W], ...$used[Color::B]]);
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
