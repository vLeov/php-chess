<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Human-like phrase.
 *
 * @license GPL
 */
class ColorPhrase
{
    /**
     * Array of phrases.
     *
     * @var array
     */
    public static $phrase = [
        [
            'color' => "w",
            'meaning' => "White",
        ],
        [
            'color' => "b",
            'meaning' => "Black",
        ],
    ];

    public static function sentence(string $color): ?string
    {
        foreach (self::$phrase as $item) {
            if ($item['color'] === $color) {
                return $item['meaning'];
            }
        }

        return null;
    }
}
