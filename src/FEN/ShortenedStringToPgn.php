<?php

namespace Chess\FEN;

/**
 * Shortened FEN string to PGN converter.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class ShortenedStringToPgn extends AbstractStringToPgn
{
    protected function find(array $legal)
    {
        foreach ($legal as $key => $val) {
            if (str_starts_with(current($val), $this->toFen)) {
                return key($val);
            }
        }

        return null;
    }
}
