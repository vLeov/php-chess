<?php

namespace Chess\Tutor;

use Chess\Eval\ExplainEvalInterface;
use Chess\Function\StandardFunction;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * FenExplanation
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class FenExplanation extends AbstractParagraph
{
    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(ClassicalBoard $board)
    {
        $this->board = $board;

        foreach ((new StandardFunction())->getEval() as $key => $val) {
            $eval = new $key($this->board);
            if (is_a($eval, ExplainEvalInterface::class)) {
                if ($phrases = $eval->getExplanation()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
        }
    }
}
