<?php

namespace Chess;

use Chess\PGN\Symbol;

/**
 * Ascii.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Ascii
{
    private $board;

    private $array;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->array = [
            7 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            6 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            5 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            4 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            3 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            2 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            1 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
            0 => [' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . '],
        ];

        $this->build();
    }

    public function toArray()
    {
        return $this->array;
    }

    public function print()
    {
        $ascii = '';
        foreach ($this->array as $i => $rank) {
            foreach ($rank as $j => $file) {
                $ascii .= $this->array[$i][$j];
            }
            $ascii .= PHP_EOL;
        }

        return $ascii;
    }

    protected function build()
    {
        foreach ($this->board->getPieces() as $piece) {
            $position = $piece->getPosition();
            $rank = $position[0];
            $file = $position[1] - 1;
            if (Symbol::WHITE === $piece->getColor()) {
                $this->array[$file][ord($rank)-97] = ' '.$piece->getIdentity().' ';
            } else {
                $this->array[$file][ord($rank)-97] = ' '.strtolower($piece->getIdentity()).' ';
            }
        }
    }
}
