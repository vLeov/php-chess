<?php

namespace Chess\Eval;

use Chess\Eval\SqCount;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * Connectivity.
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class ConnectivityEval extends AbstractEval implements
    DiscreteEvalInterface,
    ExplainEvalInterface
{
    use ExplainEvalTrait;

    const NAME = 'Connectivity';

    private object $sqCount;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->sqCount = (new SqCount($board))->count();

        $this->range = [1, 4];

        $this->subject =  [
            'The white pieces',
            'The black pieces',
        ];

        $this->observation = [
            "are slightly better connected",
            "are somewhat better connected",
            "are significantly better connected",
            "are so better connected",
        ];

        foreach ($this->board->getPieces() as $piece) {
            switch ($piece->getId()) {
                case Piece::K:
                    $this->result[$piece->getColor()] += count(
                        array_intersect((array) $piece->getMobility(),
                        $this->sqCount->used->{$piece->getColor()})
                    );
                    break;
                case Piece::N:
                    $this->result[$piece->getColor()] += count(
                        array_intersect($piece->getMobility(),
                        $this->sqCount->used->{$piece->getColor()})
                    );
                    break;
                case Piece::P:
                    $this->result[$piece->getColor()] += count(
                        array_intersect($piece->getCaptureSqs(),
                        $this->sqCount->used->{$piece->getColor()})
                    );
                    break;
                default:
                    foreach ((array) $piece->getMobility() as $key => $val) {
                        foreach ($val as $sq) {
                            if (in_array($sq, $this->sqCount->used->{$piece->getColor()})) {
                                $this->result[$piece->getColor()] += 1;
                                break;
                            } elseif (in_array($sq, $this->sqCount->used->{$piece->oppColor()})) {
                                break;
                            }
                        }
                    }
                    break;
            }
        }

        $this->explain($this->result);
    }
}
