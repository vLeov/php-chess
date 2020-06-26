<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
use PGNChess\Evaluation\System\Values;
use PGNChess\PGN\Symbol;

/**
 * Material.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Material extends AbstractEvaluation
{
    private $values;

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

        foreach ($this->board->getPiecesByColor(Symbol::WHITE) as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KNIGHT:
                    $result[Symbol::WHITE] += $this->values[$name][Symbol::KNIGHT];
                    break;
                case Symbol::BISHOP:
                    $result[Symbol::WHITE] += $this->values[$name][Symbol::BISHOP];
                    break;
                case Symbol::ROOK:
                    $result[Symbol::WHITE] += $this->values[$name][Symbol::ROOK];
                    break;
                case Symbol::QUEEN:
                    $result[Symbol::WHITE] += $this->values[$name][Symbol::QUEEN];
                    break;
                case Symbol::KING:
                    isset($this->values[$name][Symbol::KING])
                        ? $result[Symbol::WHITE] += $this->values[$name][Symbol::KING]
                        : false;
                    break;
            }
        }

        foreach ($this->board->getPiecesByColor(Symbol::BLACK) as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KNIGHT:
                    $result[Symbol::BLACK] += $this->values[$name][Symbol::KNIGHT];
                    break;
                case Symbol::BISHOP:
                    $result[Symbol::BLACK] += $this->values[$name][Symbol::BISHOP];
                    break;
                case Symbol::ROOK:
                    $result[Symbol::BLACK] += $this->values[$name][Symbol::ROOK];
                    break;
                case Symbol::QUEEN:
                    $result[Symbol::BLACK] += $this->values[$name][Symbol::QUEEN];
                    break;
                case Symbol::KING:
                    isset($this->values[$name][Symbol::KING])
                        ? $result[Symbol::BLACK] += $this->values[$name][Symbol::KING]
                        : false;
                    break;
            }
        }

        return $result;
    }
}
