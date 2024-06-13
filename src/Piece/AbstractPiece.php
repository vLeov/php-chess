<?php

namespace Chess\Piece;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Classical\Board;

abstract class AbstractPiece
{
    public string $color;

    public string $sq;

    public Square $square;

    public string $id;

    public array $mobility;

    public array $move;

    public Board $board;

    public function __construct(string $color, string $sq, Square $square, string $id)
    {
        $this->color = $color;
        $this->sq = $sq;
        $this->square = $square;
        $this->id = $id;
    }

    abstract public function legalSqs(): array;

    abstract public function defendedSqs(): ?array;

    public function file(): string
    {
        return $this->sq[0];
    }

    public function rank(): int
    {
        return (int) substr($this->sq, 1);
    }

    public function oppColor(): string
    {
        return $this->board->color->opp($this->color);
    }

    public function attackedPieces(): ?array
    {
        $attackedPieces = [];
        foreach ($sqs = $this->legalSqs() as $sq) {
            if ($piece = $this->board->getPieceBySq($sq)) {
                if ($piece->color === $this->oppColor()) {
                    $attackedPieces[] = $piece;
                }
            }
        }

        return $attackedPieces;
    }

    public function attackingPieces(): ?array
    {
        $attackingPieces = [];
        foreach ($this->board->pieces($this->oppColor()) as $piece) {
            if (in_array($this->sq, $piece->legalSqs())) {
                $attackingPieces[] = $piece;
            }
        }

        return $attackingPieces;
    }

    public function defendingPieces(): ?array
    {
        $defendingPieces = [];
        foreach ($this->board->pieces($this->color) as $piece) {
            if (in_array($this->sq, $piece->defendedSqs())) {
                $defendingPieces[] = $piece;
            }
        }

        return $defendingPieces;
    }

    public function isAttackingKing(): bool
    {
        foreach ($this->attackedPieces() as $piece) {
            if ($piece->id === Piece::K) {
                return true;
            }
        }

        return false;
    }

    public function isMovable(): bool
    {
        if ($this->move) {
            return in_array($this->move['sq']['next'], $this->legalSqs());
        }

        return false;
    }

    public function isPinned(): bool
    {
        $king = $this->board->getPiece($this->color, Piece::K);
        $clone = $this->board->clone();
        $clone->detach($clone->getPieceBySq($this->sq));
        $clone->refresh();
        $newKing = $clone->getPiece($this->color, Piece::K);
        $diffPieces = $this->board->diffPieces($king->attackingPieces(), $newKing->attackingPieces());
        foreach ($diffPieces as $diffPiece) {
            if ($diffPiece->color !== $king->color) {
                return true;
            }
        }

        return false;
    }
}
