<?php

namespace PGNChess\Stats;

use PgnChess\Board;
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
    public static function squares(Board $board): \stdClass
    {
        $pieces = iterator_to_array($board, false);

        return (object) [
            'used' => self::used($pieces),
            'free' => self::free($pieces)
        ];
    }

    /**
     * Squares being controlled by both players.
     *
     * @return \stdClass
     */
    public static function control(Board $board): \stdClass
    {
        $control = (object) [
            'space' => (object) [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ],
            'attack' => (object) [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ], ];

        $squares = self::squares($board);

        $board->rewind();
        while ($board->valid()) {
            $piece = $board->current();
            switch ($piece->getIdentity()) {
                case Symbol::KING:
                    $control->space->{$piece->getColor()} = array_unique(
                        array_merge(
                            $control->space->{$piece->getColor()},
                            array_values(
                                array_intersect(
                                    array_values((array) $piece->getScope()),
                                    $squares->free
                                )
                            )
                        )
                    );
                    $control->attack->{$piece->getColor()} = array_unique(
                        array_merge(
                            $control->attack->{$piece->getColor()},
                            array_values(
                                array_intersect(
                                    array_values((array) $piece->getScope()),
                                    $squares->used->{$piece->getOppositeColor()}
                                )
                            )
                        )
                    );
                    break;

                case Symbol::PAWN:
                    $control->space->{$piece->getColor()} = array_unique(
                        array_merge(
                            $control->space->{$piece->getColor()},
                            array_intersect(
                                $piece->getCaptureSquares(),
                                $squares->free
                            )
                        )
                    );
                    $control->attack->{$piece->getColor()} = array_unique(
                        array_merge(
                            $control->attack->{$piece->getColor()},
                            array_intersect(
                                $piece->getCaptureSquares(),
                                $squares->used->{$piece->getOppositeColor()}
                            )
                        )
                    );
                    break;

                default:
                    $control->space->{$piece->getColor()} = array_unique(
                        array_merge(
                            $control->space->{$piece->getColor()},
                            array_diff(
                                $piece->getLegalMoves(),
                                $squares->used->{$piece->getOppositeColor()}
                            )
                        )
                    );
                    $control->attack->{$piece->getColor()} = array_unique(
                        array_merge(
                            $control->attack->{$piece->getColor()},
                            array_intersect(
                                $piece->getLegalMoves(),
                                $squares->used->{$piece->getOppositeColor()}
                            )
                        )
                    );
                    break;
            }
            $board->next();
        }

        sort($control->space->{Symbol::WHITE});
        sort($control->space->{Symbol::BLACK});
        sort($control->attack->{Symbol::WHITE});
        sort($control->attack->{Symbol::BLACK});

        return $control;
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
