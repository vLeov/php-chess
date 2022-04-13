<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\SqEvaluation;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

/**
 * Space evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class SpaceEvaluation extends AbstractEvaluation
{
    const NAME = 'space';

    private array $sqEval;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $sqEval = new SqEvaluation($board);

        $this->sqEval = [
            SqEvaluation::TYPE_FREE => $sqEval->eval(SqEvaluation::TYPE_FREE),
            SqEvaluation::TYPE_USED => $sqEval->eval(SqEvaluation::TYPE_USED),
        ];

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];
    }

    public function eval(): array
    {
        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
            switch ($piece->getId()) {
                case Piece::K:
                    $this->result[$piece->getColor()] = array_unique(
                        [
                            ...$this->result[$piece->getColor()],
                            ...array_values(
                                array_intersect(
                                    array_values((array) $piece->getTravel()),
                                    $this->sqEval[SqEvaluation::TYPE_FREE]
                                )
                            )
                        ]
                    );
                    break;
                case Piece::P:
                    $this->result[$piece->getColor()] = array_unique(
                        [
                            ...$this->result[$piece->getColor()],
                            ...array_intersect(
                                $piece->getCaptureSquares(),
                                $this->sqEval[SqEvaluation::TYPE_FREE]
                            )
                        ]
                    );
                    break;
                default:
                    $this->result[$piece->getColor()] = array_unique(
                        [
                            ...$this->result[$piece->getColor()],
                            ...array_diff(
                                $piece->getSqs(),
                                $this->sqEval[SqEvaluation::TYPE_USED][$piece->getOppColor()]
                            )
                        ]
                    );
                    break;
            }
            $this->board->next();
        }

        sort($this->result[Color::W]);
        sort($this->result[Color::B]);

        return $this->result;
    }
}
