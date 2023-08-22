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
            $this->enPassant();
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

    public function enPassant()
    {
        if ($history = $this->board->getHistory()) {
            $last = array_slice($history, -1)[0];
            if ($last->move->id === Piece::P) {
                $prevFile = intval(substr($last->sq, 1));
                $nextFile = intval(substr($last->move->sq->next, 1));
                if ($last->move->color === Color::W) {
                    if ($nextFile - $prevFile === 2) {
                        $rank = $prevFile + 1;
                        return $last->move->sq->current.$rank;
                    }
                } elseif ($prevFile - $nextFile === 2) {
                    $rank = $prevFile - 1;
                    return $last->move->sq->current.$rank;
                }
            }
        }

        return '-';
    }
}
