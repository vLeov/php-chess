<?php

namespace Chess\Eval;

use Chess\Eval\DefenseEval;
use Chess\Eval\PressureEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

/**
 * Tactics evaluation.
 *
 * Total piece value obtained from the squares that are not being defended.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class TacticsEval extends AbstractEval
{
    const NAME = 'Tactics';

    /**
     * Defense evaluation containing the defended squares.
     *
     * @var array
     */
    private array $defenseEval;

    /**
     * Pressure evaluation containing the squares being pressured.
     *
     * @var array
     */
    private array $pressEval;

    /**
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->defenseEval = (new DefenseEval($board))->getResult();
        $this->pressEval = (new PressureEval($board))->getResult();

        foreach ($this->pressEval as $color => $sqs) {
            $countPress = array_count_values($sqs);
            $countDefense = array_count_values($this->defenseEval[Color::opp($color)]);
            foreach ($sqs as $sq) {
                if (in_array($sq, $this->defenseEval[Color::opp($color)])) {
                    if ($countPress[$sq] > $countDefense[$sq]) {
                        $this->result[$color] += self::$value[$this->board->getPieceBySq($sq)->getId()];
                    }
                } else {
                    $this->result[$color] += self::$value[$this->board->getPieceBySq($sq)->getId()];
                }
            }
        }
    }
}
