<?php

namespace Chess\Piece;

use Chess\Variant\Classical\PGN\AN\Castle;

/**
 * Rook type.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class RType
{
    const CASTLE_SHORT = Castle::SHORT;
    const CASTLE_LONG = Castle::LONG;
    const PROMOTED = 'promoted';
    const SLIDER = 'slider';

    public static function all(): array
    {
        return [
            self::CASTLE_SHORT,
            self::CASTLE_LONG,
            self::PROMOTED,
            self::SLIDER
        ];
    }
}
