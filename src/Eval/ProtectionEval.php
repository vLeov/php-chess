<?php

namespace Chess\Eval;

use Chess\Eval\DefenseEval;
use Chess\Eval\PressureEval;
use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

/**
 * Protection evaluation.
 *
 * Total piece value obtained from the squares that are not being defended.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class ProtectionEval extends AbstractEval
{
    const NAME = 'Protection';

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
                $piece = $this->board->getPieceBySq($sq);
                if (in_array($sq, $this->defenseEval[Color::opp($color)])) {
                    if ($countPress[$sq] > $countDefense[$sq]) {
                        $this->result[$color] += self::$value[$piece->getId()];
                        $this->explain($piece);
                    }
                } else {
                    $this->result[$color] += self::$value[$piece->getId()];
                    $this->explain($piece);
                }
            }
        }
    }

    private function explain(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);
        if (!in_array($phrase, $this->phrases)) {
            $this->phrases[] = ucfirst("$phrase is unprotected.");
        }
    }
}
