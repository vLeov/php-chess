<?php

namespace Chess\Tutor;

use Chess\Function\AbstractFunction;
use Chess\Variant\Classical\Board;

class PgnEvaluation extends AbstractParagraph
{
    public function __construct(string $pgn, AbstractFunction $function, Board $board)
    {
        $this->function = $function;
        $this->board = $board;

        $fenEvaluation = new FenEvaluation($this->function, $this->board);
        $this->board = $fenEvaluation->board;
        $this->board->play($board->turn, $pgn);

        foreach ((new FenEvaluation($this->function, $this->board))->paragraph as $key => $val) {
            if (!in_array($val, $fenEvaluation->paragraph)) {
                $this->paragraph[] = $val;
            }
        }
    }
}
