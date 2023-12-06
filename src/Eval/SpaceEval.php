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

    protected array $phrase = [
        Color::W => [
            [
                'diff' => 8,
                'meanings' => [
                    "White has an absolute space advantage.",
                ],
            ],
            [
                'diff' => 5,
                'meanings' => [
                    "White has a remarkable space advantage.",
                ],
            ],
            [
                'diff' => 3,
                'meanings' => [
                    "White has a somewhat better space advantage.",
                ],
            ],
            [
                'diff' => 2,
                'meanings' => [
                    "White has a slightly better space advantage.",
                ],
            ],
        ],
        Color::B => [
            [
                'diff' => -8,
                'meanings' => [
                    "Black has an absolute space advantage.",
                ],
            ],
            [
                'diff' => -5,
                'meanings' => [
                    "Black has a remarkable space advantage.",
                ],
            ],
            [
                'diff' => -3,
                'meanings' => [
                    "Black has a somewhat better space advantage.",
                ],
            ],
            [
                'diff' => -2,
                'meanings' => [
                    "Black has a slightly better space advantage.",
                ],
            ],
        ],
    ];

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

        if ($sentence = $this->sentence($result)) {
            $this->phrases[] = $sentence;
        }
    }
}
