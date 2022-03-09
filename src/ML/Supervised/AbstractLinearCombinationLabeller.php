<?php

namespace Chess\ML\Supervised;

abstract class AbstractLinearCombinationLabeller
{
    abstract public function label(array $end);
}
