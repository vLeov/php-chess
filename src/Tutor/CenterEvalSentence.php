<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Human-like sentence.
 *
 * @license GPL
 */
class CenterEvalSentence
{
    /**
     * Array of phrases.
     *
     * @var array
     */
    public static $phrase = [
        Color::W => [
            [
                'diff' => 4,
                'meanings' => [
                    "White has an absolute control of the center.",
                ],
            ],
            [
                'diff' => 3,
                'meanings' => [
                    "White has a remarkable control of the center.",
                ],
            ],
            [
                'diff' => 2,
                'meanings' => [
                    "White has a somewhat better control of the center.",
                ],
            ],
            [
                'diff' => 1,
                'meanings' => [
                    "White has a slightly better control of the center.",
                ],
            ],
        ],
        Color::B => [
            [
                'diff' => -4,
                'meanings' => [
                    "Black has an absolute control of the center.",
                ],
            ],
            [
                'diff' => -3,
                'meanings' => [
                    "Black has a remarkable control of the center.",
                ],
            ],
            [
                'diff' => -2,
                'meanings' => [
                    "Black has a somewhat better control of the center.",
                ],
            ],
            [
                'diff' => -1,
                'meanings' => [
                    "Black has a slightly better control of the center.",
                ],
            ],
        ],
    ];

    public static function predictable(array $result): ?string
    {
        $diff = $result[Color::W] - $result[Color::B];

        if ($diff > 0) {
            foreach (self::$phrase[Color::W] as $item) {
                if ($diff > $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        } else {
            foreach (self::$phrase[Color::B] as $item) {
                if ($diff < $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        }

        return null;
    }
}
