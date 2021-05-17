<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\DefenseEvaluation;
use Chess\Evaluation\PressureEvaluation;
use Chess\PGN\Symbol;

/**
 * Tactics evaluation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class TacticsEvaluation extends AbstractEvaluation
{
    const NAME = 'tactics';

    private $defenseEvald;

    private $pressEvald;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->defenseEvald = (new DefenseEvaluation($board))->evaluate();
        $this->pressEvald = (new PressureEvaluation($board))->evaluate();

        $this->result = [
            Symbol::WHITE => [],
            Symbol::BLACK => [],
        ];
    }

    public function evaluate($feature = null): array
    {
        foreach ($this->pressEvald as $color => $squares) {
            $countPress = array_count_values($squares);
            $countDefense = array_count_values($this->defenseEvald[Symbol::oppColor($color)]);
            foreach ($squares as $square) {
                if (in_array($square, $this->defenseEvald[Symbol::oppColor($color)])) {
                    if ($countPress[$square] > $countDefense[$square]) {
                        $this->result[$color][] = $square;
                    }
                } else {
                    $this->result[$color][] = $square;
                }
            }
        }

        return $this->result;
    }
}
