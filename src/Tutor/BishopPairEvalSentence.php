<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\PGN\AN\Color;

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
        Color::W => [
            [
                'diff' => 1,
                'meanings' => [
                    "White has the bishop pair.",
                ],
            ],
        ],
        Color::B => [
            [
                'diff' => -1,
                'meanings' => [
                    "Black has the bishop pair.",
                ],
            ],
        ],
    ];


    public static function predictable(array $result): ?string
    {
        $diff = $result[Color::W] - $result[Color::B];

        if ($diff > 0) {
            foreach (self::$phrase[Color::W] as $item) {
                if ($diff >= $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        }

        if ($diff < 0) {
            foreach (self::$phrase[Color::B] as $item) {
                if ($diff <= $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        }

        return null;
    }
}
