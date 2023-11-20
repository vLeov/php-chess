<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Material.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class MaterialEval extends AbstractEval
{
    const NAME = 'Material';

    public function eval(): array
    {
        foreach ($this->board->getPieces(Color::W) as $piece) {
            if ($piece->getId() !== Piece::K) {
                $this->result[Color::W] += $this->value[$piece->getId()];
            }
        }
        foreach ($this->board->getPieces(Color::B) as $piece) {
            if ($piece->getId() !== Piece::K) {
                $this->result[Color::B] += $this->value[$piece->getId()];
            }
        }
        $this->result[Color::W] = round($this->result[Color::W], 2);
        $this->result[Color::B] = round($this->result[Color::B], 2);

        return $this->result;
    }
}
