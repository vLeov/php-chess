<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\Attack as AttackEvaluation;
use Chess\PGN\Symbol;

/**
 * Attacked evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Attacked extends AbstractEvaluation
{
    const NAME = 'attacked';

    private $attEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->attEvald = (new AttackEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function evaluate($feature = null): array
    {
        $this->result = [
            Symbol::WHITE => $this->attEvald[Symbol::BLACK],
            Symbol::BLACK => $this->attEvald[Symbol::WHITE],
        ];

        return $this->result;
    }
}
