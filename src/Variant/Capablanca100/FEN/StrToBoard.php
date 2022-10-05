<?php

namespace Chess\Variant\Capablanca100\FEN;

use Chess\Array\PieceArray;
use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\FEN\StrToBoard as ClassicalFenStrToBoard;
use Chess\Variant\Classical\Board;

/**
 * StrToBoard
 *
 * Converts a FEN string to a Chess\Board object.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class StrToBoard extends ClassicalFenStrToBoard
{
    public function __construct(string $string)
    {
        $this->string = Str::validate($string);

        $this->fields = array_filter(explode(' ', $this->string));

        $this->castlingAbility = $this->fields[2];
    }

    public function create(): Board
    {
        try {
            $asciiArray = Str::toAsciiArray($this->fields[0]);
            $pieces = (new PieceArray($asciiArray))->getArray();
            $board = (new Board($pieces, $this->castlingAbility))
                ->setTurn($this->fields[1]);
            if ($this->fields[3] !== '-') {
                $board = $this->doublePawnPush($board);
            }
        } catch (\Throwable $e) {
            throw new UnknownNotationException;
        }

        return $board;
    }
}
