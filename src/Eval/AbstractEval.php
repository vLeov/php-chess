<?php

namespace Chess\Eval;

use Chess\Variant\Capablanca\PGN\AN\Piece;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

/**
 * Abstract evaluation.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
abstract class AbstractEval
{
    protected static $value = [
        Piece::A => 6.53,
        Piece::B => 3.33,
        Piece::C => 8.3,
        Piece::K => 4,
        Piece::N => 3.2,
        Piece::P => 1,
        Piece::Q => 8.8,
        Piece::R => 5.1,
    ];

    protected Board $board;

    protected array $result = [
        Color::W => 0,
        Color::B => 0,
    ];

    protected array $phrases = [];

    public function getResult()
    {
        return $this->result;
    }

    public function getPhrases()
    {
        return $this->phrases;
    }

    protected function sentence(array $result): ?string
    {
        $diff = $result[Color::W] - $result[Color::B];

        if ($diff > 0) {
            foreach ($this->phrase[Color::W] as $item) {
                if ($diff >= $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        }

        if ($diff < 0) {
            foreach ($this->phrase[Color::B] as $item) {
                if ($diff <= $item['diff']) {
                    return $item['meanings'][0];
                }
            }
        }

        return null;
    }
}
