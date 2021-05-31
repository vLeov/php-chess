<?php

namespace Chess;

/**
 * Ascii.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Ascii
{
    private $fen;

    public function __construct(Fen $fen)
    {
        $this->fen = $fen;
    }
}
