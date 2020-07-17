<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Space as SpaceEvaluation;
use PGNChess\Evaluation\Square as SquareEvaluation;
use PGNChess\PGN\Symbol;

/**
 * King safety.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class KingSafety extends AbstractEvaluation
{
    const NAME = 'safety';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 1,
        ];
    }

    public function evaluate($feature = null): array
    {
        $attEvald = (new AttackEvaluation($this->board))->evaluate();
        $spEvald = (new SpaceEvaluation($this->board))->evaluate();
        $sqEvald = (new SquareEvaluation($this->board))->evaluate(SquareEvaluation::FEATURE_USED);

        $this->color(Symbol::WHITE, $feature, $attEvald, $spEvald, $sqEvald);
        $this->color(Symbol::BLACK, $feature, $attEvald, $spEvald, $sqEvald);

        return $this->result;
    }

    private function color(string $color, string $feature, array $attEvald, array $spEvald, array $sqEvald)
    {
        $king = $this->board->getPiece($color, Symbol::KING);
        foreach ($king->getScope() as $key => $sq) {
            if ($piece = $this->board->getPieceByPosition($sq)) {
                $this->result[$color] += 1;
            }
            if (in_array($sq, $attEvald[$king->getOppColor()])) {
                $this->result[$color] -= 1;
            }
            if (in_array($sq, $spEvald[$king->getOppColor()])) {
                $this->result[$color] -= 2;
            }
            if (in_array($sq, $sqEvald[$king->getOppColor()])) {
                $this->result[$color] -= 3;
            }
            if ($this->board->isCheck()) {
                $this->result[$color] -= 4;
            }
        }
    }
}
