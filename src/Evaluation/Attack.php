<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
use PGNChess\Evaluation\Square as SquareEvaluation;
use PGNChess\PGN\Symbol;

/**
 * Attack evaluation.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Attack extends AbstractEvaluation
{
    const FEATURE_ATTACK = 'attack';

    private $sqEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sqEvald = [
            SquareEvaluation::FEATURE_FREE => (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_FREE),
            SquareEvaluation::FEATURE_USED => (new SquareEvaluation($board))->evaluate(SquareEvaluation::FEATURE_USED),
        ];
    }

    public function evaluate(string $name): array
    {
        $result = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];

        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
            switch ($piece->getIdentity()) {
                case Symbol::KING:
                    $result[$piece->getColor()] = array_unique(
                        array_merge(
                            $result[$piece->getColor()],
                            array_values(
                                array_intersect(
                                    array_values((array) $piece->getScope()),
                                    $this->sqEvald[SquareEvaluation::FEATURE_USED][$piece->getOppositeColor()]
                                )
                            )
                        )
                    );
                    break;
                case Symbol::PAWN:
                    $result[$piece->getColor()] = array_unique(
                        array_merge(
                            $result[$piece->getColor()],
                            array_intersect(
                                $piece->getCaptureSquares(),
                                $this->sqEvald[SquareEvaluation::FEATURE_USED][$piece->getOppositeColor()]
                            )
                        )
                    );
                    break;
                default:
                    $result[$piece->getColor()] = array_unique(
                        array_merge(
                            $result[$piece->getColor()],
                            array_intersect(
                                $piece->getLegalMoves(),
                                $this->sqEvald[SquareEvaluation::FEATURE_USED][$piece->getOppositeColor()]
                            )
                        )
                    );
                    break;
            }
            $this->board->next();
        }

        sort($result[Symbol::WHITE]);
        sort($result[Symbol::BLACK]);

        return $result;
    }
}
