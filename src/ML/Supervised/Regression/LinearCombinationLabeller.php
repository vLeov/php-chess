<?php

namespace Chess\ML\Supervised\Regression;

use Chess\ML\Supervised\AbstractLinearCombinationLabeller;

class LinearCombinationLabeller extends AbstractLinearCombinationLabeller
{
    public function label(array $end)
    {
        $sum = 0;
        foreach ($end as $key => $val) {
            $sum += pow(2, $key) * $val;
        }

        return $sum;
    }
}
