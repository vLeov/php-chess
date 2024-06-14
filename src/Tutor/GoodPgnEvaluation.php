<?php

namespace Chess\Tutor;

use Chess\UciEngine\UciEngine;
use Chess\UciEngine\Details\Limit;
use Chess\Variant\Classical\Board;

class GoodPgnEvaluation extends AbstractParagraph
{
    private Limit $limit;

    private UciEngine $uciEngine;

    private string $pgn;

    public function __construct(Limit $limit, UciEngine $uciEngine, Board $board)
    {
        $this->limit = $limit;
        $this->uciEngine = $uciEngine;
        $this->board = $board;

        $analysis = $uciEngine->analysis($this->board, $limit);

        $clone = $this->board->clone();
        $clone->playLan($clone->turn, $analysis['bestmove']);

        $last = array_slice($clone->history, -1)[0];

        $this->pgn = $last['move']['pgn'];

        $this->paragraph = (new PgnEvaluation($this->pgn, $this->board))->paragraph;
    }

    public function getLimit(): Limit
    {
        return $this->limit;
    }

    public function getUciEngine(): UciEngine
    {
        return $this->uciEngine;
    }

    public function getPgn(): string
    {
        return $this->pgn;
    }
}
