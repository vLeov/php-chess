<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\PressureEvaluation;
use Chess\Evaluation\SpaceEvaluation;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

/**
 * King safety.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class KingSafetyEvaluation extends AbstractEvaluation
{
    const NAME = 'safety';

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
        $pressEval = (new PressureEvaluation($this->board))->eval();
        $spEval = (new SpaceEvaluation($this->board))->eval();

        $this->color(Color::W, $pressEval, $spEval);
        $this->color(Color::B, $pressEval, $spEval);

        return $this->result;
    }

    private function color(string $color, array $pressEval, array $spEval): void
    {
        $king = $this->board->getPiece($color, Piece::K);
        foreach ($king->getTravel() as $key => $sq) {
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
