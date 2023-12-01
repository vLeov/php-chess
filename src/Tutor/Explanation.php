<?php

namespace Chess\Tutor;

use Chess\Piece\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Human-like explanation.
 *
 * @license GPL
 */
class Explanation
{
    /**
     * Array of explanations.
     *
     * @var array
     */
    public static $explanation = [
        [
            'pgn' => "N",
            'meanings' => [
                "White's knight",
                "white knight",
            ],
        ],
        [
            'pgn' => "n",
            'meanings' => [
                "Black's knight",
                "black knight",
            ],
        ],
    ];

    public static function deterministic(AbstractPiece $piece): ?string
    {
        $pgn = $piece->getColor() === Color::W
            ? $piece->getId()
            : mb_strtolower($piece->getId());

        foreach (self::$explanation as $item) {
            if ($item['pgn'] === $pgn) {
                return $item['meanings'][0];
            }
        }

        return null;
    }
}
