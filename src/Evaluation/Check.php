<?php

namespace PGNChess\Evaluation;

use PgnChess\Board;
use PGNChess\PGN\Symbol;

/**
 * Check.
 *
 * @author Jordi Bassagañas
 * @link https://programarivm.com
 * @license GPL
 */
class Check extends AbstractEvaluation
{
    const NAME = 'check';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function evaluate($feature = null): array
    {
        if ($this->board->isCheck()) {
            $this->result[Symbol::oppColor($this->board->getTurn())] = 1;
        }

        return $this->result;
    }
}
