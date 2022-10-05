<?php

namespace Chess\Variant\Capablanca100\FEN;

use Chess\Variant\Capablanca100\FEN\Str;
use Chess\Variant\Classical\FEN\StrToBoard as ClassicalFenStrToBoard;

/**
 * StrToBoard
 *
 * Converts a FEN string to a chessboard object.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class StrToBoard extends ClassicalFenStrToBoard
{
    protected string $boardClassName = '\\Chess\\Variant\\Capablanca100\\Board';

    public function __construct(string $string)
    {
        $this->fenStr = new Str();
        $this->string = $this->fenStr->validate($string);
        $this->fields = array_filter(explode(' ', $this->string));
        $this->castlingAbility = $this->fields[2];
    }
}
