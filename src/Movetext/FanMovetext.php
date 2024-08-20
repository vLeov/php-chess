<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;

class FanMovetext extends AbstractMovetext
{
    public array $metadata;

    public SanMovetext $sanMovetext;

    public function __construct(Move $move, string $movetext)
    {
        $this->sanMovetext = new SanMovetext($move, $this->toSan($movetext));
        $this->move = $this->sanMovetext->move;
        $this->movetext = $this->sanMovetext->movetext;
        $this->moves = array_map(function($move) {
            return $this->toFan($move);
        }, $this->sanMovetext->moves);

        $this->metadata = [
            'firstMove' => $this->toFan($this->sanMovetext->metadata['firstMove']),
            'lastMove' => $this->toFan($this->sanMovetext->metadata['lastMove']),
            'turn' => $this->sanMovetext->metadata['turn'],
        ];
    }

    protected function beforeInsert(): FanMovetext
    {
        return $this;
    }

    protected function insert(): void
    {
    }

    public function validate(): string
    {
        $this->sanMovetext->validate();

        return $this->toFan($this->sanMovetext->validated);
    }

    public function filtered($comments = true, $nags = true): string
    {
        $filtered = $this->sanMovetext->filtered($comments, $nags);

        return $this->toFan($filtered);
    }

    private function toFan(string $move): string
    {
        $move = $this->replace('R', '♖', $move);
        $move = $this->replace('N', '♘', $move);
        $move = $this->replace('B', '♗', $move);
        $move = $this->replace('Q', '♕', $move);
        $move = $this->replace('K', '♔', $move);

        return $move;
    }

    private function toSan(string $move): string
    {
        $move = str_replace('♖', 'R', $move);
        $move = str_replace('♘', 'N', $move);
        $move = str_replace('♗', 'B', $move);
        $move = str_replace('♕', 'Q', $move);
        $move = str_replace('♔', 'K', $move);

        return $move;
    }

    private function replace($letter, $unicode, $move): string
    {
        preg_match_all('/' . Move::KING . '/', $move, $matches);
        $move = $this->move($letter, $unicode, $matches, $move);

        preg_match_all('/' . Move::KING_CAPTURES . '/', $move, $matches);
        $move = $this->move($letter, $unicode, $matches, $move);

        preg_match_all('/' . Move::KNIGHT . '/', $move, $matches);
        $move = $this->move($letter, $unicode, $matches, $move);

        preg_match_all('/' . Move::KNIGHT_CAPTURES . '/', $move, $matches);
        $move = $this->move($letter, $unicode, $matches, $move);

        preg_match_all('/' . Move::PIECE . '/', $move, $matches);
        $move = $this->move($letter, $unicode, $matches, $move);

        preg_match_all('/' . Move::PIECE_CAPTURES . '/', $move, $matches);
        $move = $this->move($letter, $unicode, $matches, $move);

        return $move;
    }

    private function move($letter, $unicode, $matches, $move)
    {
        foreach ($matches[0] as $match) {
            $replaced = str_replace($letter, $unicode, $match);
            $move = str_replace($match, $replaced, $move);
        }

        return $move;
    }
}
