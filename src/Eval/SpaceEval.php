<?php

namespace Chess\Eval;

use Chess\Eval\SqCount;
use Chess\Tutor\SpaceEvalSentence;
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

    private object $sqCount;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->sqCount = (new SqCount($board))->count();

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        foreach ($pieces = $this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::K) {
                $this->result[$piece->getColor()] = array_unique(
                    [
                        ...$this->result[$piece->getColor()],
                        ...array_intersect(
                            (array) $piece->getMobility(),
                            $this->sqCount->free
                        )
                    ]
                );
            } elseif ($piece->getId() === Piece::P) {
                $this->result[$piece->getColor()] = array_unique(
                    [
                        ...$this->result[$piece->getColor()],
                        ...array_intersect(
                            $piece->getCaptureSqs(),
                            $this->sqCount->free
                        )
                    ]
                );
            } else {
                $this->result[$piece->getColor()] = array_unique(
                    [
                        ...$this->result[$piece->getColor()],
                        ...array_diff(
                            $piece->sqs(),
                            $this->sqCount->used->{$piece->oppColor()}
                        )
                    ]
                );
            }
        }

        $this->explain($this->result);
    }

    private function explain(array $result): void
    {
        $result[Color::W] = count($result[Color::W]);
        $result[Color::B] = count($result[Color::B]);

        if ($sentence = SpaceEvalSentence::predictable($result)) {
            $this->phrases[] = $sentence;
        }
    }
}
