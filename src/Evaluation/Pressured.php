<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\Pressure as PressureEvaluation;
use Chess\PGN\Symbol;

/**
 * Pressured evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Pressured extends AbstractEvaluation
{
    const NAME = 'pressured';

    private $pressEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->pressEvald = (new PressureEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function evaluate($feature = null): array
    {
        $this->result = [
            Symbol::WHITE => $this->pressEvald[Symbol::BLACK],
            Symbol::BLACK => $this->pressEvald[Symbol::WHITE],
        ];

        return $this->result;
    }
}
