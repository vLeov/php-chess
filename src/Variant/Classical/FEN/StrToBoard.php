<?php

namespace Chess\Variant\Classical\FEN;

use Chess\Array\PieceArray;
use Chess\Array\AsciiArray;
use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\FEN\Str;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

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
    protected Str $fenStr;

    protected string $boardClassName = '\\Chess\\Variant\\Classical\\Board';

    protected string $string;

    protected array $fields;

    protected string $castlingAbility;

    public function __construct(string $string)
    {
        $this->fenStr = new Str();
        $this->string = $this->fenStr->validate($string);
        $this->fields = array_filter(explode(' ', $this->string));
        $this->castlingAbility = $this->fields[2];
    }

    public function create(): Board
    {
        try {
            $asciiArray = $this->fenStr->toAsciiArray($this->fields[0]);
            $pieces = (new PieceArray($asciiArray))->getArray();
            $board = (new $this->boardClassName($pieces, $this->castlingAbility))
                ->setTurn($this->fields[1]);
            if ($this->fields[3] !== '-') {
                $board = $this->doublePawnPush($board);
            }
        } catch (\Throwable $e) {
            throw new UnknownNotationException;
        }

        return $board;
    }

    protected function doublePawnPush(Board $board)
    {
        $file = $this->fields[3][0];
        $rank = intval(substr($this->fields[3], 1));
        if ($this->fields[1] === Color::W) {
            $piece = ' p ';
            $fromRank = $rank + 1;
            $toRank = $rank - 1;
            $turn = Color::B;
        } else {
            $piece = ' P ';
            $fromRank = $rank - 1;
            $toRank = $rank + 1;
            $turn = Color::W;
        }
        $fromSq = $file.$fromRank;
        $toSq = $file.$toRank;
        $array = (new AsciiArray($board->toAsciiArray()))
            ->setElem($piece, $fromSq)
            ->setElem(' . ', $toSq)
            ->getArray();
        $board = (new AsciiArray($array))
            ->toBoard($turn, $board->getCastlingAbility());
        $board->play($turn, $toSq);

        return $board;
    }
}
