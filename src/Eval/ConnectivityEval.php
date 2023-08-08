<?php

namespace Chess\Eval;

use Chess\Eval\SqEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * Connectivity.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class ConnectivityEval extends AbstractEval
{
    const NAME = 'Connectivity';

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
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        $this->color(Color::W);
        $this->color(Color::B);

        return $this->result;
    }

    private function color(string $color): void
    {
        foreach ($this->board->getPieces($color) as $piece) {
            switch ($piece->getId()) {
                case Piece::K:
                    $this->result[$color] += count(
                        array_intersect(array_values((array)$piece->getMobility()),
                        $this->sqEval[SqEval::TYPE_USED][$color])
                    );
                    break;
                case Piece::N:
                    $this->result[$color] += count(
                        array_intersect($piece->getMobility(),
                        $this->sqEval[SqEval::TYPE_USED][$color])
                    );
                    break;
                case Piece::P:
                    $this->result[$color] += count(
                        array_intersect($piece->getCaptureSqs(),
                        $this->sqEval[SqEval::TYPE_USED][$color])
                    );
                    break;
                default:
                    foreach ((array)$piece->getMobility() as $key => $val) {
                        foreach ($val as $sq) {
                            if (in_array($sq, $this->sqEval[SqEval::TYPE_USED][$color])) {
                                $this->result[$color] += 1;
                                break;
                            } elseif (in_array($sq, $this->sqEval[SqEval::TYPE_USED][$piece->oppColor()])) {
                                break;
                            }
                        }
                    }
                    break;
            }
        }
    }
}
