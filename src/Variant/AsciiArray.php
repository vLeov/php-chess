<?php

namespace Chess\Variant;

use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Square;

class AsciiArray
{
    protected array $array;

    protected Square $square;

    private array $castlingRule;

    public function __construct(array $array, Square $square, array $castlingRule)
    {
        $this->array = $array;
        $this->square = $square;
        $this->castlingRule = $castlingRule;
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function setElem(string $elem, string $sq): AsciiArray
    {
        $index = self::toIndex($sq);
        $this->array[$index[0]][$index[1]] = $elem;

        return $this;
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
