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
        [
            'diff' => -4,
            'color' => 'b',
            'meanings' => [
                "The black pieces are absolutely better connected.",
            ],
        ],
        [
            'diff' => -3,
            'color' => 'b',
            'meanings' => [
                "The black pieces are remarkably better connected.",
            ],
        ],
        [
            'diff' => -2,
            'color' => 'b',
            'meanings' => [
                "The black pieces are somewhat better connected.",
            ],
        ],
        [
            'diff' => -1,
            'color' => 'b',
            'meanings' => [
                "The black pieces are slightly better connected.",
            ],
        ],
        [
            'diff' => 1,
            'color' => 'w',
            'meanings' => [
                "The white pieces are slightly better connected.",
            ],
        ],
        [
            'diff' => 2,
            'color' => 'w',
            'meanings' => [
                "The white pieces are somewhat better connected.",
            ],
        ],
        [
            'diff' => 3,
            'color' => 'w',
            'meanings' => [
                "The white pieces are remarkably better connected.",
            ],
        ],
        [
            'diff' => 4,
            'color' => 'w',
            'meanings' => [
                "The white pieces are absolutely better connected.",
            ],
        ],
    ];

    public static function predictable(array $result): ?string
    {
        $diff = $result[Color::W] - $result[Color::B];

        foreach (self::$phrase as $item) {
            if ($item['color'] === Color::W) {
                if ($diff > $item['diff']) {
                    return $item['meanings'][0];
                }
            } elseif ($item['color'] === Color::B) {
                if ($diff < $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        }

        return null;
    }
}
