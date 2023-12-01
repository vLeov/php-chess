<?php

namespace Chess\Eval;

use Chess\Eval\DefenseEval;
use Chess\Eval\PressureEval;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
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
     * @var array[]
     */
    private array $target;

    /**
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->defenseEval = (new DefenseEval($board))->getResult();
        $this->pressEval = (new PressureEval($board))->getResult();

        $this->target = [
            Color::W => [],
            Color::B => [],
        ];

        $this->target();

        foreach ($this->target as $color => $sqs) {
            foreach ($sqs as $sq) {
                $id = $this->board->getPieceBySq($sq)->getId();
                if ($id !== Piece::K) {
                    $this->result[$color] += self::$value[$id];
                }
            }
        }
    }

    /**
     * Calculates the squares that are not being defended.
     *
     * @return void
     */
    protected function target(): void
    {
        foreach ($this->pressEval as $color => $sqs) {
            $countPress = array_count_values($sqs);
            $countDefense = array_count_values($this->defenseEval[Color::opp($color)]);
            foreach ($sqs as $sq) {
                if (in_array($sq, $this->defenseEval[Color::opp($color)])) {
                    if ($countPress[$sq] > $countDefense[$sq]) {
                        $this->target[$color][] = $sq;
                    }
                } else {
                    $this->target[$color][] = $sq;
                }
            }
        }
    }
}
