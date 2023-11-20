<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Attack evaluation.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class AttackEval extends AbstractEval
{
    const NAME = 'Attack';

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            switch ($piece->getId()) {
                case Piece::K:
                    // TODO ...
                    break;
                case Piece::P:
                    foreach ($piece->getCaptureSqs() as $sq) {
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
                    foreach ($piece->sqs() as $sq) {
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
