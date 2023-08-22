<?php

namespace Chess\Variant\Classical\FEN;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * BoardToStr
 *
 * Converts a Chess\Board object to a FEN string.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class BoardToStr
{
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function create(): string
    {
        $string = '';
        $array = $this->board->toAsciiArray();
        for ($i = $this->board->getSize()['ranks'] - 1; $i >= 0; $i--) {
            $string .= str_replace(' ', '', implode('', $array[$i]));
            if ($i != 0) {
                $string .= '/';
            }
        }

        return $this->filter($string).' '.
            $this->board->getTurn().' '.
            $this->board->getCastlingAbility().' '.
            $this->board->enPassant();
    }

    private function filter(string $string)
    {
        $filtered = '';
        $strSplit = str_split($string);
        $n = 1;
        for ($i = 0; $i < count($strSplit); $i++) {
            if ($strSplit[$i] === '.') {
                if (isset($strSplit[$i+1]) && $strSplit[$i+1] === '.') {
                    $n++;
                } else {
                    $filtered .= $n;
                    $n = 1;
                }
            } else {
                $filtered .= $strSplit[$i];
                $n = 1;
            }
        }

        return $filtered;
    }
}
