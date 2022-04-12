<?php

namespace Chess\Piece;

/**
 * RookType.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class RookType
{
    const O_O = 'castle short';
    const O_O_O = 'castle long';
    const PROMOTED = 'promoted';
    const SLIDER = 'slider';

    public static function all(): array
    {
        return [
            self::O_O,
            self::O_O_O,
            self::PROMOTED,
            self::SLIDER
        ];
    }
}
