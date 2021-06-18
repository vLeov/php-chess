<?php

namespace Chess\Castling;

use Chess\Board;
use Chess\Castling\Rule as CastlingRule;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * Castling initialization.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Initialization
{
    public static $initialState = [
        Symbol::WHITE => [
            CastlingRule::IS_CASTLED => false,
            Symbol::CASTLING_SHORT => true,
            Symbol::CASTLING_LONG => true,
        ],
        Symbol::BLACK => [
            CastlingRule::IS_CASTLED => false,
            Symbol::CASTLING_SHORT => true,
            Symbol::CASTLING_LONG => true,
        ],
    ];
}
