<?php

namespace Chess\Variant\Classical\PGN\AN;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\AsciiArray;
use Chess\Variant\Classical\PGN\AbstractNotation;

class Square extends AbstractNotation
{
    const REGEX = '[a-h]{1}[1-8]{1}';

    const SIZE = [
        'files' => 8,
        'ranks' => 8,
    ];

    const EXTRACT = '/[^a-h0-9 "\']/';

    public function validate(string $value): string
    {
        if (!preg_match('/^' . static::REGEX . '$/', $value)) {
            throw new UnknownNotationException();
        }

        return $value;
    }

     public function color(string $sq): string
     {
        $file = $sq[0];
        $rank = substr($sq, 1);

        if ((ord($file) - 97) % 2 === 0) {
            if ($rank % 2 !== 0) {
                return Color::B;
            }
        } else {
            if ($rank % 2 === 0) {
                return Color::B;
            }
        }

        return Color::W;
     }

     public function all(): array
     {
         $all = [];
         for ($i = 0; $i < static::SIZE['files']; $i++) {
             for ($j = 0; $j < static::SIZE['ranks']; $j++) {
                 $all[] = AsciiArray::toAlgebraic($i, $j);
             }
         }

         return $all;
     }
}
