<?php

namespace Chess\FEN;

/**
 * FEN string to PGN converter.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class StringToPgn extends AbstractStringToPgn
{
    protected function find(array $legal)
    {
        foreach ($legal as $key => $val) {
            if ($this->toFen === current($val)) {
                return key($val);
            }
        }

        return null;
    }
}
