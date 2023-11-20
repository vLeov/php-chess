<?php

namespace Chess\Eval;

use Chess\Eval\SqCount;
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

    private object $sqCount;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sqCount = (new SqCount($board))->count();
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
                        array_intersect((array)$piece->getMobility(),
                        $this->sqCount->used->{$color})
                    );
                    break;
                case Piece::N:
                    $this->result[$color] += count(
                        array_intersect($piece->getMobility(),
                        $this->sqCount->used->{$color})
                    );
                    break;
                case Piece::P:
                    $this->result[$color] += count(
                        array_intersect($piece->getCaptureSqs(),
                        $this->sqCount->used->{$color})
                    );
                    break;
                default:
                    foreach ((array)$piece->getMobility() as $key => $val) {
                        foreach ($val as $sq) {
                            if (in_array($sq, $this->sqCount->used->{$color})) {
                                $this->result[$color] += 1;
                                break;
                            } elseif (in_array($sq, $this->sqCount->used->{$piece->oppColor()})) {
                                break;
                            }
                        }
                    }
                    break;
            }
        }
    }
}
