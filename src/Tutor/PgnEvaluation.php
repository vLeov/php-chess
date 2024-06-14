<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board;

class PgnEvaluation extends AbstractParagraph
{
    public function __construct(string $pgn, Board $board)
    {
        $this->board = $board;

        $fenEvaluation = new FenEvaluation($this->board);
        $this->board = $fenEvaluation->board;
        $this->board->play($board->turn, $pgn);

        foreach ((new FenEvaluation($this->board))->paragraph as $key => $val) {
            if (!in_array($val, $fenEvaluation->paragraph)) {
                $this->paragraph[] = $val;
            }
        }
    }
}
