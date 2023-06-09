<?php

namespace Chess\Variant\Chess960\FEN;

use Chess\Exception\UnknownNotationException;
use Chess\Piece\AsciiArray;
use Chess\Piece\PieceArray;
use Chess\Variant\Chess960\Board;
use Chess\Variant\Chess960\Rule\CastlingRule;
use Chess\Variant\Classical\FEN\Str;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\PGN\AN\Square;

/**
 * StrToBoard
 *
 * Converts a FEN string to a chessboard object.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class StrToBoard
{
    protected array $size;

    protected Str $fenStr;

    protected string $string;

    protected array $fields;

    protected string $castlingAbility;

    private array $startPos;

    protected array $castlingRule;

    public function __construct(string $string, array $startPos)
    {
        $this->size = Square::SIZE;
        $this->fenStr = new Str();
        $this->string = $this->fenStr->validate($string);
        $this->fields = array_filter(explode(' ', $this->string));
        $this->castlingAbility = $this->fields[2];
        $this->startPos = $startPos;
        $this->castlingRule =  (new CastlingRule($this->startPos))->getRule();
    }

    public function create(): Board
    {
        try {
            $pieces = (new PieceArray(
                $this->fenStr->toAsciiArray($this->fields[0]),
                $this->size,
                $this->castlingRule
            ))->getArray();
            $board = (new Board(
                $this->startPos,
                $pieces,
                $this->castlingAbility
            ))->setTurn($this->fields[1])->setStartFen($this->string);
            $board = $this->enPassant($board);
        } catch (\Throwable $e) {
            throw new UnknownNotationException();
        }

        return $board;
    }

    protected function enPassant(Board $board)
    {
        if ($this->fields[3] !== '-') {
            foreach ($pieces = $board->getPieces($this->fields[1]) as $piece) {
                if ($piece->getId() === Piece::P) {
                    if (in_array($this->fields[3], $piece->getCaptureSqs())) {
                        $piece->setEnPassantSq($this->fields[3]);
                    }
                }
            }
        }

        return $board;
    }
}
