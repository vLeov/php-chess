<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\AttackEvaluation;
use Chess\PGN\Symbol;

/**
 * Guard evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class GuardEvaluation extends AbstractEvaluation
{
    const NAME = 'guard';

    private $attackEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->attackEvald = (new AttackEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => 32,
            Symbol::BLACK => 32,
        ];
    }

    public function evaluate($feature = null): array
    {
        $this->result[Symbol::WHITE] -= $this->attackEvald[Symbol::BLACK];
        $this->result[Symbol::BLACK] -= $this->attackEvald[Symbol::WHITE];

        return $this->result;
    }
}
