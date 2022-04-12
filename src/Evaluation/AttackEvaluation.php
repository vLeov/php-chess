<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\SAN\Color;
use Chess\PGN\SAN\Piece;

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
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            switch ($piece->getId()) {
                case Piece::K:
                    // TODO ...
                    break;
                case Piece::P:
                    foreach ($piece->getCaptureSquares() as $sq) {
                        if ($item = $this->board->getPieceBySq($sq)) {
                            if ($item->getColor() !== $piece->getColor()) {
                                $id = $item->getId();
                                if ($id !== Piece::K && $this->value[Piece::P] < $this->value[$id]) {
                                    $this->result[$piece->getColor()] += $this->value[$id] - $this->value[Piece::P];
                                }
                            }
                        }
                    }
                    break;
                default:
                    foreach ($piece->getSqs() as $sq) {
                        if ($item = $this->board->getPieceBySq($sq)) {
                            if ($item->getColor() !== $piece->getColor()) {
                                $id = $item->getId();
                                if ($id !== Piece::K && $this->value[$piece->getId()] < $this->value[$id]) {
                                    $this->result[$piece->getColor()] += $this->value[$id] - $this->value[$piece->getId()];
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
