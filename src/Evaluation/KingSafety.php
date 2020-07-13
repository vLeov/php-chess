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
        foreach ($this->board->getPiece(Symbol::WHITE, Symbol::KING)->getScope() as $key => $sq) {
            if ($piece = $this->board->getPieceByPosition($sq)) {
                $this->result[Symbol::WHITE] += $this->system[$feature][$piece->getIdentity()];
            }
        }

        foreach ($this->board->getPiece(Symbol::BLACK, Symbol::KING)->getScope() as $key => $sq) {
            if ($piece = $this->board->getPieceByPosition($sq)) {
                $this->result[Symbol::BLACK] += $this->system[$feature][$piece->getIdentity()];
            }
        }

        return $this->result;
    }
}
