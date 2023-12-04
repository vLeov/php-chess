<?php

namespace Chess\Tutor;

/**
 * Human-like sentence.
 *
 * @license GPL
 */
class BishopPairEvalSentence
{
    /**
     * Array of phrases.
     *
     * @var array
     */
    public static $phrase = [
        [
            'color' => 'w',
            'meanings' => [
                "White has the bishop pair.",
            ],
        ],
        [
            'color' => 'b',
            'meanings' => [
                "Black has the bishop pair.",
            ],
        ],
    ];

    public static function predictable(string $color): ?string
    {
        foreach (self::$phrase as $item) {
            if ($item['color'] === $color) {
                return $item['meanings'][0];
            }
        }

        return null;
    }
}
