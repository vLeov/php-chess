<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PGNChess\PGN\Symbol;

/**
 * Square stats.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Square extends AbstractEvaluation
{
    /**
     * Current free/used squares.
     *
     * @param array $pieces
     * @return \stdClass
     */
    public function squares(): \stdClass
    {
        $pieces = iterator_to_array($this->board, false);

        return (object) [
            'used' => $this->used($pieces),
            'free' => $this->free($pieces)
        ];
    }

    /**
     * Squares being controlled by both players.
     *
     * @return \stdClass
     */
    public function control(): \stdClass
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

        $squares = $this->squares();

        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
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
            $this->board->next();
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
     * Squares currently used by both players.
     *
     * @return array
     */
    private function used(array $pieces): \stdClass
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
    private function free(array $pieces): array
    {
        $used = $this->used($pieces);

        return array_values(
            array_diff(
                $this->all(),
                array_merge($used->{Symbol::WHITE}, $used->{Symbol::BLACK})
        ));
    }
}
