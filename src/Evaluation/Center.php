<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
use PGNChess\PGN\Symbol;

/**
 * Center.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Center extends AbstractEvaluation
{
    private $center = ['d4', 'd5', 'e4', 'e5'];

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function evaluate(string $feature): array
    {
        foreach ($this->center as $square) {
            if ($piece = $this->board->getPieceByPosition($square)) {
                switch ($piece->getIdentity()) {
                    case Symbol::KNIGHT:
                        $this->result[$piece->getColor()] += $this->system[$feature][Symbol::KNIGHT];
                        break;
                    case Symbol::BISHOP:
                        $this->result[$piece->getColor()] += $this->system[$feature][Symbol::BISHOP];
                        break;
                    case Symbol::ROOK:
                        $this->result[$piece->getColor()] += $this->system[$feature][Symbol::ROOK];
                        break;
                    case Symbol::QUEEN:
                        $this->result[$piece->getColor()] += $this->system[$feature][Symbol::QUEEN];
                        break;
                    case Symbol::PAWN:
                        $this->result[$piece->getColor()] += 1;
                        break;
                }
            }
        }

        return $this->result;
    }
}
