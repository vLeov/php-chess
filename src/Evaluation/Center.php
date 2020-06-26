<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
use PGNChess\Evaluation\System\Values;
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
    private $values;

    private $center = ['d4', 'd5', 'e4', 'e5'];

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->values = (new Values())->get();
    }

    public function evaluate(string $name): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        foreach ($this->center as $square) {
            if ($piece = $this->board->getPieceByPosition($square)) {
                switch ($piece->getIdentity()) {
                    case Symbol::KNIGHT:
                        $result[$piece->getColor()] += $this->values[$name][Symbol::KNIGHT];
                        break;
                    case Symbol::BISHOP:
                        $result[$piece->getColor()] += $this->values[$name][Symbol::BISHOP];
                        break;
                    case Symbol::ROOK:
                        $result[$piece->getColor()] += $this->values[$name][Symbol::ROOK];
                        break;
                    case Symbol::QUEEN:
                        $result[$piece->getColor()] += $this->values[$name][Symbol::QUEEN];
                        break;
                    case Symbol::PAWN:
                        $result[$piece->getColor()] += 1;
                        break;
                }
            }
        }

        return $result;
    }
}
