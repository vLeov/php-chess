<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\AN\Color;

/**
 * Defense evaluation.
 *
 * Squares containing the pieces being defended at the present moment.
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
            Color::W => [],
            Color::B => [],
        ];
    }

    /**
     * Returns the squares containing the pieces being defended at the present moment.
     *
     * @return array
     */
    public function eval(): array
    {
        $this->board->rewind();
        while ($this->board->valid()) {
            $piece = $this->board->current();
            $this->result[$piece->getColor()] = [
                ...$this->result[$piece->getColor()],
                ...$piece->getDefendedSqs()
            ];
            $this->board->next();
        }

        sort($this->result[Color::W]);
        sort($this->result[Color::B]);

        return $this->result;
    }
}
