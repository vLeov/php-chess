<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Composition;
use Chess\PGN\SAN\Color;
use Chess\PGN\SAN\Piece;

class AbsolutePinEvaluation extends AbstractEvaluation implements InverseEvaluationInterface
{
    const NAME = 'absolute_pin';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K) {
                $composition = (new Composition($this->board))
                    ->setTurn($piece->getOppColor())
                    ->deletePieceByPosition($piece->getSquare())
                    ->getBoard();
                if ($composition->isCheck()) {
                    $this->result[$piece->getColor()] += $this->value[$piece->getId()];
                }
            }
        }

        return $this->result;
    }
}
