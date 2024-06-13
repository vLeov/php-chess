<?php

namespace Chess\Tutor;

use Chess\StandardFunction;
use Chess\Eval\ExplainEvalInterface;
use Chess\Variant\Classical\Board;

class FenExplanation extends AbstractParagraph
{
    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ((new StandardFunction())->getEval() as $val) {
            $eval = new $val($this->board);
            if (is_a($eval, ExplainEvalInterface::class)) {
                if ($phrases = $eval->getExplanation()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
        }
    }
}
