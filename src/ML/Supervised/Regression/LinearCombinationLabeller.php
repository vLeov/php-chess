<?php

namespace Chess\ML\Supervised\Regression;

use Chess\ML\Supervised\AbstractLinearCombinationLabeller;

class LinearCombinationLabeller extends AbstractLinearCombinationLabeller
{
    public function label(array $end)
    {
        return array_sum($end);
    }
}
