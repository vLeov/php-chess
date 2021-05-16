<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\SquareEvaluation;
use Chess\PGN\Symbol;

/**
 * Pressure evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PressureEvaluation extends AbstractEvaluation
{
    const NAME = 'pressure';

    private $sqEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $sqEval = new SquareEvaluation($board);

        $this->sqEvald = [
            SquareEvaluation::FEATURE_FREE => $sqEval->evaluate(SquareEvaluation::FEATURE_FREE),
            SquareEvaluation::FEATURE_USED => $sqEval->evaluate(SquareEvaluation::FEATURE_USED),
        ];

        $this->result = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function evaluate($feature = null): array
    {
        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
            switch ($piece->getIdentity()) {
                case Symbol::KING:
                    $this->result[$piece->getColor()] = array_merge(
                        $this->result[$piece->getColor()],
                        array_values(
                            array_intersect(
                                array_values((array) $piece->getScope()),
                                $this->sqEvald[SquareEvaluation::FEATURE_USED][$piece->getOppColor()]
                            )
                        )
                    );
                    break;
                case Symbol::PAWN:
                    $this->result[$piece->getColor()] = array_merge(
                        $this->result[$piece->getColor()],
                        array_intersect(
                            $piece->getCaptureSquares(),
                            $this->sqEvald[SquareEvaluation::FEATURE_USED][$piece->getOppColor()]
                        )
                    );
                    break;
                default:
                    $this->result[$piece->getColor()] = array_merge(
                        $this->result[$piece->getColor()],
                        array_intersect(
                            $piece->getLegalMoves(),
                            $this->sqEvald[SquareEvaluation::FEATURE_USED][$piece->getOppColor()]
                        )
                    );
                    break;
            }
            $this->board->next();
        }

        sort($this->result[Symbol::WHITE]);
        sort($this->result[Symbol::BLACK]);

        return $this->result;
    }
}
