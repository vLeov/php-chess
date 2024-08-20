<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Piece;

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

    private function toFan(string &$movetext): string
    {
        $this->replace(Piece::R, '♖', $movetext);
        $this->replace(Piece::N, '♘', $movetext);
        $this->replace(Piece::B, '♗', $movetext);
        $this->replace(Piece::Q, '♕', $movetext);
        $this->replace(Piece::K, '♔', $movetext);

        return $movetext;
    }

    private function toSan(string $movetext): string
    {
        $movetext = str_replace('♖', Piece::R, $movetext);
        $movetext = str_replace('♘', Piece::N, $movetext);
        $movetext = str_replace('♗', Piece::B, $movetext);
        $movetext = str_replace('♕', Piece::Q, $movetext);
        $movetext = str_replace('♔', Piece::K, $movetext);

        return $movetext;
    }

    private function replace($letter, $unicode, &$movetext): void
    {
        if ($letter === Piece::K) {
            preg_match_all('/' . Move::KING . '/', $movetext, $a);
            preg_match_all('/' . Move::KING_CAPTURES . '/', $movetext, $b);
        } elseif ($letter === Piece::N) {
            preg_match_all('/' . Move::KNIGHT . '/', $movetext, $a);
            preg_match_all('/' . Move::KNIGHT_CAPTURES . '/', $movetext, $b);
        } else {
            preg_match_all('/' . Move::PIECE . '/', $movetext, $a);
            preg_match_all('/' . Move::PIECE_CAPTURES . '/', $movetext, $b);
        }
        $matches = [...$a[0], ...$b[0]];
        $this->move($letter, $unicode, $matches, $movetext);
    }

    private function move($letter, $unicode, $matches, &$movetext): void
    {
        array_map(function($match) use ($letter, $unicode, &$movetext) {
            $replaced = str_replace($letter, $unicode, $match);
            $movetext = str_replace($match, $replaced, $movetext);
        }, $matches);
    }
}
