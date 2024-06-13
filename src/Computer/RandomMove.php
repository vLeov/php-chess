<?php

namespace Chess\Computer;

use Chess\Variant\Classical\Board;

class RandomMove
{
    protected Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board->clone();
    }

    public function move(): ?object
    {
        $legal = [];
        foreach ($this->board->getPieces($this->board->turn) as $piece) {
            if ($sqs = $piece->legalSqs()) {
                $legal[$piece->sq] = $sqs;
            }
        }

        $from = array_rand($legal);
        shuffle($legal[$from]);
        $to = $legal[$from][0];

        $lan = "{$from}{$to}";

        if ($this->board->playLan($this->board->turn, $lan)) {
            $last = array_slice($this->board->history, -1)[0];
            return (object) [
                'pgn' => $last['move']['pgn'],
                'lan' => $lan,
            ];
        }

        return null;
    }
}
