<?php

namespace Chess\ML\Supervised\Regression;

use Chess\ML\Supervised\AbstractLabeller;

class SumLabeller extends AbstractLabeller
{
    public function label(array $end)
    {
        $sum = array_sum($end);

        return round($sum, 2);
    }
}
