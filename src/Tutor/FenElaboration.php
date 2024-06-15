<?php

namespace Chess\Tutor;

use Chess\StandardFunction;
use Chess\Eval\ElaborateEvalInterface;
use Chess\Variant\AbstractBoard;

class FenElaboration extends AbstractParagraph
{
    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        foreach ((new StandardFunction())->getEval() as $val) {
            $eval = new $val($this->board);
            if (is_a($eval, ElaborateEvalInterface::class)) {
                if ($phrases = $eval->getElaboration()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
        }
    }
}
