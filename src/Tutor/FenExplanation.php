<?php

namespace Chess\Tutor;

use Chess\Eval\ExplainEvalInterface;
use Chess\Function\StandardFunction;
use Chess\Variant\AbstractBoard;

class FenExplanation extends AbstractParagraph
{
    public function __construct(AbstractBoard $board)
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
