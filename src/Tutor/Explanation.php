<?php

namespace Chess\Tutor;

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

    public static function deterministic(string $pgn): ?string
    {
        foreach (self::$explanation as $item) {
            if ($item['pgn'] === $pgn) {
                return $item['meanings'][0];
            }
        }

        return null;
    }
}
