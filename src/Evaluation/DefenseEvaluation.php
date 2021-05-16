<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\Symbol;

/**
 * Defense evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class DefenseEvaluation extends AbstractEvaluation
{
    const NAME = 'defense';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function evaluate($feature = null): array
    {
        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
            $this->result[$piece->getColor()] = array_merge(
                $this->result[$piece->getColor()],
                $piece->getDefendedSquares()
            );
            $this->board->next();
        }

        sort($this->result[Symbol::WHITE]);
        sort($this->result[Symbol::BLACK]);

        return $this->result;
    }
}
