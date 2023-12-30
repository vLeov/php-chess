<?php

namespace Chess\ML\Supervised\Classification;

use Chess\ML\Supervised\AbstractLabeller;
use Chess\Variant\Classical\PGN\AN\Color;

class CountLabeller extends AbstractLabeller
{
    public function label(array $end)
    {
        $result = [
            Color::W => 0,
            Color::B => 0,
        ];

        foreach ($end as $key => $val) {
            if ($val > 0) {
                $result[Color::W] += 1;
            } elseif ($val < 0) {
                $result[Color::B] += 1;
            }
        }

        return $result;
    }
}
