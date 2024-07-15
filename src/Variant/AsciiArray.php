<?php

namespace Chess\Variant;

class AsciiArray
{
    protected array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public static function toIndex(string $sq): array
    {
        $j = ord($sq[0]) - 97;
        $i = intval(ltrim($sq, $sq[0])) - 1;

        return [
            $i,
            $j,
        ];
    }

    public static function toAlgebraic(int $i, int $j): string
    {
        $file = chr(97 + $i);
        $rank = $j + 1;

        return $file.$rank;
    }
}
