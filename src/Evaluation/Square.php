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
    const TYPE_ATTACK           = 'attack';
    const TYPE_FREE             = 'free';
    const TYPE_SPACE            = 'space';
    const TYPE_USED             = 'used';

    const FEATURE_CONTROL       = 'FEATURE_CONTROL';

    public function evaluate(string $name): array
    {
        $control = $this->control();

        switch ($name) {
            case self::FEATURE_CONTROL:
                return [
                    Symbol::WHITE => [
                        self::TYPE_ATTACK => count($control->{self::TYPE_ATTACK}->{Symbol::WHITE}),
                        self::TYPE_SPACE => count($control->{self::TYPE_SPACE}->{Symbol::WHITE}),
                    ],
                    Symbol::BLACK => [
                        self::TYPE_ATTACK => count($control->{self::TYPE_ATTACK}->{Symbol::BLACK}),
                        self::TYPE_SPACE => count($control->{self::TYPE_SPACE}->{Symbol::BLACK}),
                    ],
                ];
        }
    }

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
            self::TYPE_USED => $this->used($pieces),
            self::TYPE_FREE => $this->free($pieces),
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
            self::TYPE_SPACE => (object) [
                Symbol::WHITE => [],
                Symbol::BLACK => [],
            ],
            self::TYPE_ATTACK => (object) [
                Symbol::WHITE => [],
                Symbol::BLACK => [],
            ],
        ];

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
