<?php

namespace Chess\Tutor;

use Chess\Piece\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Human-like phrase.
 *
 * @license GPL
 */
class PiecePhrase
{
    /**
     * Array of phrases.
     *
     * @var array
     */
    public static $phrase = [
        [
            'id' => "N",
            'color' => "w",
            'meanings' => [
                "White's knight",
                "white knight",
            ],
        ],
        [
            'id' => "N",
            'color' => "b",
            'meanings' => [
                "Black's knight",
                "black knight",
            ],
        ],
    ];

    public static function deterministic(AbstractPiece $piece): ?string
    {
        foreach (self::$phrase as $item) {
            if (
                $item['id'] === $piece->getId() &&
                $item['color'] === $piece->getColor()
            ) {
                return "{$item['meanings'][0]} on {$piece->getSq()}";
            }
        }

        return null;
    }
}
