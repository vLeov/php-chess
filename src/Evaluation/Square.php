<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PGNChess\PGN\Symbol;

/**
 * Square evaluation.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Square extends AbstractEvaluation
{
    const FEATURE_FREE             = 'free';
    const FEATURE_USED             = 'used';

    public function evaluate(string $name): array
    {
        $pieces = iterator_to_array($this->board, false);

        switch ($name) {
            case self::FEATURE_FREE:
                return $this->free($pieces);
            case self::FEATURE_USED:
                return $this->used($pieces);
        }
    }

    /**
     * All squares.
     *
     * @return array
     */
    private function all(): array
    {
        $all = [];
        for($i=0; $i<8; $i++) {
            for($j=1; $j<=8; $j++) {
                $all[] = chr((ord('a') + $i)) . $j;
            }
        }

        return $all;
    }

    /**
     * Free squares.
     *
     * @return array
     */
    private function free(array $pieces): array
    {
        $used = $this->used($pieces);

        return array_values(
            array_diff(
                $this->all(),
                array_merge($used[Symbol::WHITE], $used[Symbol::BLACK])
        ));
    }

    /**
     * Squares used by both players.
     *
     * @return array
     */
    private function used(array $pieces): array
    {
        $used = [
            Symbol::WHITE => [],
            Symbol::BLACK => []
        ];

        foreach ($pieces as $piece) {
            $used[$piece->getColor()][] = $piece->getPosition();
        }

        return $used;
    }
}
