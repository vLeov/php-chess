<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\PressureEvaluation;
use Chess\PGN\Symbol;

/**
 * Ease evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class EaseEvaluation extends AbstractEvaluation
{
    const NAME = 'ease';

    private $pressEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->pressEvald = (new PressureEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => 16,
            Symbol::BLACK => 16,
        ];
    }

    public function evaluate($feature = null): array
    {
        $this->result[Symbol::WHITE] -= count($this->pressEvald[Symbol::BLACK]);
        $this->result[Symbol::BLACK] -= count($this->pressEvald[Symbol::WHITE]);

        return $this->result;
    }
}
