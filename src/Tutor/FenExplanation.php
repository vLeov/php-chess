<?php

namespace Chess\Tutor;

use Chess\Eval\ExplainEvalInterface;
use Chess\Function\AbstractFunction;
use Chess\Variant\AbstractBoard;

class FenExplanation extends AbstractParagraph
{
    public function __construct(AbstractFunction $function, AbstractBoard $board)
    {
        $this->function = $function;

        $this->board = $board;

        foreach ($this->function->getEval() as $val) {
            $eval = new $val($this->board);
            if (is_a($eval, ExplainEvalInterface::class)) {
                if ($phrases = $eval->getExplanation()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
        }
    }
}
