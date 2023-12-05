<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Human-like sentence.
 *
 * @license GPL
 */
class ConnectivityEvalSentence
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
                    "The white pieces are absolutely better connected.",
                ],
            ],
            [
                'diff' => 3,
                'meanings' => [
                    "The white pieces are remarkably better connected.",
                ],
            ],
            [
                'diff' => 2,
                'meanings' => [
                    "The white pieces are somewhat better connected.",
                ],
            ],
            [
                'diff' => 1,
                'meanings' => [
                    "The white pieces are slightly better connected.",
                ],
            ],
        ],
        Color::B => [
            [
                'diff' => -4,
                'meanings' => [
                    "The black pieces are absolutely better connected.",
                ],
            ],
            [
                'diff' => -3,
                'meanings' => [
                    "The black pieces are remarkably better connected.",
                ],
            ],
            [
                'diff' => -2,
                'meanings' => [
                    "The black pieces are somewhat better connected.",
                ],
            ],
            [
                'diff' => -1,
                'meanings' => [
                    "The black pieces are slightly better connected.",
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
