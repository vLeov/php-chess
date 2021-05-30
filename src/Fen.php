<?php

namespace Chess;

use Chess\Castling\Rule as CastlingRule;
use Chess\PGN\Symbol;
use Chess\Piece\Bishop;
use Chess\Piece\King;
use Chess\Piece\Knight;
use Chess\Piece\Pawn;
use Chess\Piece\Piece;
use Chess\Piece\Queen;
use Chess\Piece\Rook;
use Chess\Piece\Type\RookType;

/**
 * FEN.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Fen
{
    private $fen;

    private $fields;

    private $castling;

    private $pieces;

    public function __construct(string $fen)
    {
        $this->fen = $fen;

        $this->fields = array_filter(explode(' ', $this->fen));

        $this->castling = [
            Symbol::WHITE => [
                CastlingRule::IS_CASTLED => false,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => true,
            ],
            Symbol::BLACK => [
                CastlingRule::IS_CASTLED => false,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => true,
            ],
        ];

        $this->pieces = [];

        $this->castling();
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getCastling()
    {
        return $this->castling;
    }

    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * Sets the current turn.
     *
     * @param string $fen
     * @return array
     */
    public function load()
    {
        $rows = array_filter(explode('/', $this->fields[0]));
        foreach ($rows as $key => $row) {
            $rank = 'a';
            $file = 8 - $key;
            foreach (str_split($row) as $char) {
                if (ctype_lower($char)) {
                    $char = strtoupper($char);
                    $this->pushPiece(Symbol::BLACK, $char, $rank.$file);
                    $rank = chr(ord($rank) + 1);
                } elseif (ctype_upper($char)) {
                    $this->pushPiece(Symbol::WHITE, $char, $rank.$file);
                    $rank = chr(ord($rank) + 1);
                } elseif (is_numeric($char)) {
                    $rank = chr(ord($rank) + $char);
                }
            }
        }

        return $this;
    }

    protected function castling()
    {
        switch (true) {
            case !strpos($this->fen[2], 'K') && !strpos($this->fen[2], 'Q'):
                $this->castling[Symbol::WHITE][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::WHITE][Symbol::CASTLING_LONG] = false;
                break;
            case !strpos($this->fen[2], 'K'):
                $this->castling[Symbol::WHITE][Symbol::CASTLING_SHORT] = false;
                break;
            case !strpos($this->fen[2], 'Q'):
                $this->castling[Symbol::WHITE][Symbol::CASTLING_LONG] = false;
                break;
            case !strpos($this->fen[2], 'k') && !strpos($this->fen[2], 'q'):
                $this->castling[Symbol::BLACK][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::BLACK][Symbol::CASTLING_LONG] = false;
                break;
            case !strpos($this->fen[2], 'k'):
                $this->castling[Symbol::BLACK][Symbol::CASTLING_SHORT] = false;
                break;
            case !strpos($this->fen[2], 'q'):
                $this->castling[Symbol::BLACK][Symbol::CASTLING_LONG] = false;
                break;
            case $this->fen[2] === '-':
                $this->castling[Symbol::WHITE][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::WHITE][Symbol::CASTLING_LONG] = false;
                $this->castling[Symbol::BLACK][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::BLACK][Symbol::CASTLING_LONG] = false;
                break;
            default:
                // do nothing
                break;
        }
    }

    protected function pushPiece($color, $char, $square)
    {
        switch ($char) {
            case Symbol::KING:
                $this->pieces[] = new King($color, $square);
                break;
            case Symbol::QUEEN:
                $this->pieces[] = new Queen($color, $square);
                break;
            case Symbol::ROOK:
                if ($color === Symbol::BLACK &&
                    $square === 'a8' &&
                    $this->castling[$color][Symbol::CASTLING_LONG]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_LONG);
                } elseif (
                    $color === Symbol::BLACK &&
                    $square === 'h8' &&
                    $this->castling[$color][Symbol::CASTLING_SHORT]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_SHORT);
                } elseif (
                    $color === Symbol::WHITE &&
                    $square === 'a1' &&
                    $this->castling[$color][Symbol::CASTLING_LONG]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_LONG);
                } elseif (
                    $color === Symbol::WHITE &&
                    $square === 'h1' &&
                    $this->castling[$color][Symbol::CASTLING_SHORT]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_SHORT);
                } else {
                    // in this case it really doesn't matter which RookType is assigned to the rook
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_LONG);
                }
                break;
            case Symbol::BISHOP:
                $this->pieces[] = new Bishop($color, $square);
                break;
            case Symbol::KNIGHT:
                $this->pieces[] = new Knight($color, $square);
                break;
            case Symbol::PAWN:
                $this->pieces[] = new Pawn($color, $square);
                break;
            default:
                // do nothing
                break;
        }
    }
}
