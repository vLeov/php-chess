<?php

namespace Chess\Eval;

use Chess\Eval\SqEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * Space evaluation.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class SpaceEval extends AbstractEval
{
    const NAME = 'Space';

    private array $sqEval;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $sqEval = new SqEval($board);

        $this->sqEval = [
            SqEval::TYPE_FREE => $sqEval->eval(SqEval::TYPE_FREE),
            SqEval::TYPE_USED => $sqEval->eval(SqEval::TYPE_USED),
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
                                    array_values((array) $piece->getMobility()),
                                    $this->sqEval[SqEval::TYPE_FREE]
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
                                $piece->getCaptureSqs(),
                                $this->sqEval[SqEval::TYPE_FREE]
                            )
                        ]
                    );
                    break;
                default:
                    $this->result[$piece->getColor()] = array_unique(
                        [
                            ...$this->result[$piece->getColor()],
                            ...array_diff(
                                $piece->sqs(),
                                $this->sqEval[SqEval::TYPE_USED][$piece->oppColor()]
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
