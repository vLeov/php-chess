<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
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
    const FEATURE_DEFAULT = 'safety';

    const SYSTEM_PRIME = [
        Symbol::PAWN => 2,
        Symbol::KNIGHT => 3,
        Symbol::BISHOP => 3,
        Symbol::ROOK => 5,
        Symbol::QUEEN => 7,
    ];

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 1,
        ];
    }

    public function evaluate(string $feature): array
    {
        foreach ($this->board->getPiece(Symbol::WHITE, Symbol::KING)->getScope() as $key => $sq) {
            if ($piece = $this->board->getPieceByPosition($sq)) {
                $this->result[Symbol::WHITE] *= self::SYSTEM_PRIME[$piece->getIdentity()];
            }
        }

        foreach ($this->board->getPiece(Symbol::BLACK, Symbol::KING)->getScope() as $key => $sq) {
            if ($piece = $this->board->getPieceByPosition($sq)) {
                $this->result[Symbol::BLACK] *= self::SYSTEM_PRIME[$piece->getIdentity()];
            }
        }

        return $this->result;
    }
}
