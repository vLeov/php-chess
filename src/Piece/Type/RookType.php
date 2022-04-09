<?php

namespace Chess\Piece\Type;

/**
 * RookType class.
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

    public static function getChoices(): array
    {
        return [
            self::O_O,
            self::O_O_O,
            self::PROMOTED,
            self::SLIDER
        ];
    }
}
