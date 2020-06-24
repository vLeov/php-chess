<?php

namespace PGNChess\Stats;

use PGNChess\PGN\Symbol;

/**
 * Stats on the squares of the board.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Square
{
    /**
     * Current free/used squares.
     *
     * @param array $pieces
     * @return \stdClass
     */
    public static function current(array $pieces): \stdClass
    {
        return (object) [
            'used' => self::used($pieces),
            'free' => self::free($pieces)
        ];
    }

    /**
     * All squares.
     *
     * @return array
     */
    private static function all(): array
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
     * Squares currently used by both players.
     *
     * @return array
     */
    private static function used(array $pieces): \stdClass
    {
        $used = (object) [
            Symbol::WHITE => [],
            Symbol::BLACK => []
        ];

        foreach ($pieces as $piece) {
            $used->{$piece->getColor()}[] = $piece->getPosition();
        }

        return $used;
    }

    /**
     * Free squares.
     *
     * @return array
     */
    private static function free(array $pieces): array
    {
        $used = self::used($pieces);

        return array_values(
            array_diff(
                self::all(),
                array_merge($used->{Symbol::WHITE}, $used->{Symbol::BLACK})
        ));
    }
}
