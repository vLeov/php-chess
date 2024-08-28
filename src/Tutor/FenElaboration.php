<?php

namespace Chess\Tutor;

use Chess\Eval\ElaborateEvalInterface;
use Chess\Function\AbstractFunction;
use Chess\Variant\AbstractBoard;

class FenElaboration extends AbstractParagraph
{
    public function __construct(AbstractFunction $function, AbstractBoard $board)
    {
        $this->function = $function;

        $this->board = $board;

        foreach ($this->function->getEval() as $val) {
            $eval = new $val($this->board);
            if (is_a($eval, ElaborateEvalInterface::class)) {
                if ($phrases = $eval->getElaboration()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
        }
    }
}
