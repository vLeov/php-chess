<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PgnChess\Board;
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
        foreach ($this->board->getPiecesByColor(Symbol::WHITE) as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KNIGHT:
                    $this->result[Symbol::WHITE] += $this->system[$feature][Symbol::KNIGHT];
                    break;
                case Symbol::BISHOP:
                    $this->result[Symbol::WHITE] += $this->system[$feature][Symbol::BISHOP];
                    break;
                case Symbol::ROOK:
                    $this->result[Symbol::WHITE] += $this->system[$feature][Symbol::ROOK];
                    break;
                case Symbol::QUEEN:
                    $this->result[Symbol::WHITE] += $this->system[$feature][Symbol::QUEEN];
                    break;
                case Symbol::KING:
                    isset($this->system[$feature][Symbol::KING])
                        ? $this->result[Symbol::WHITE] += $this->system[$feature][Symbol::KING]
                        : false;
                    break;
            }
        }

        foreach ($this->board->getPiecesByColor(Symbol::BLACK) as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KNIGHT:
                    $this->result[Symbol::BLACK] += $this->system[$feature][Symbol::KNIGHT];
                    break;
                case Symbol::BISHOP:
                    $this->result[Symbol::BLACK] += $this->system[$feature][Symbol::BISHOP];
                    break;
                case Symbol::ROOK:
                    $this->result[Symbol::BLACK] += $this->system[$feature][Symbol::ROOK];
                    break;
                case Symbol::QUEEN:
                    $this->result[Symbol::BLACK] += $this->system[$feature][Symbol::QUEEN];
                    break;
                case Symbol::KING:
                    isset($this->system[$feature][Symbol::KING])
                        ? $this->result[Symbol::BLACK] += $this->system[$feature][Symbol::KING]
                        : false;
                    break;
            }
        }

        return $this->result;
    }
}
