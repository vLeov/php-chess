<?php

namespace Chess\Eval;

use Chess\Eval\PressureEval;
use Chess\Eval\SpaceEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * K safety.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class KingSafetyEval extends AbstractEval
{
    const NAME = 'King safety';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Color::W => 1,
            Color::B => 1,
        ];
    }

    public function eval(): array
    {
        $pressEval = (new PressureEval($this->board))->eval();
        $spEval = (new SpaceEval($this->board))->eval();

        $this->color(Color::W, $pressEval, $spEval);
        $this->color(Color::B, $pressEval, $spEval);

        return $this->result;
    }

    private function color(string $color, array $pressEval, array $spEval): void
    {
        $king = $this->board->getPiece($color, Piece::K);
        foreach ($king->getMobility() as $key => $sq) {
            if ($piece = $this->board->getPieceBySq($sq)) {
                if ($piece->getColor() === $king->oppColor()) {
                    $this->result[$color] -= 1;
                }
            }
            if (in_array($sq, $pressEval[$king->oppColor()])) {
                $this->result[$color] -= 1;
            }
            if (in_array($sq, $spEval[$king->oppColor()])) {
                $this->result[$color] -= 1;
            }
        }
    }
}
