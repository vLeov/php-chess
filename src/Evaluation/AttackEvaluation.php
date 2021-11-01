<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;

/**
 * Attack evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class AttackEvaluation extends AbstractEvaluation
{
    const NAME = 'attack';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function evaluate($feature = null): array
    {
        foreach ($this->board->getPieces() as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KING:
                    // TODO ...
                    break;
                case Symbol::PAWN:
                    foreach ($piece->getCaptureSquares() as $square) {
                        if ($pieceByPosition = $this->board->getPieceByPosition($square)) {
                            if ($pieceByPosition->getColor() !== $piece->getColor()) {
                                $identity = $pieceByPosition->getIdentity();
                                if ($this->value[Symbol::PAWN] < $this->value[$identity]) {
                                    $this->result[$piece->getColor()] += $this->value[$identity] - $this->value[Symbol::PAWN];
                                }
                            }
                        }
                    }
                    break;
                default:
                    foreach ($piece->getLegalMoves() as $square) {
                        if ($pieceByPosition = $this->board->getPieceByPosition($square)) {
                            if ($pieceByPosition->getColor() !== $piece->getColor()) {
                                $identity = $pieceByPosition->getIdentity();
                                if ($this->value[$piece->getIdentity()] < $this->value[$identity]) {
                                    $this->result[$piece->getColor()] += $this->value[$identity] - $this->value[$piece->getIdentity()];
                                }
                            }
                        }
                    }
                    break;
            }
        }

        return $this->result;
    }
}
