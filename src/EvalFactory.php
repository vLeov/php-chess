<?php

namespace Chess;

use Chess\Function\AbstractFunction;
use Chess\Variant\Classical\Board;

class EvalFactory
{
    public static function create(AbstractFunction $function, string $name, Board $board)
    {
        foreach ($function->getEval() as $val) {
            $class = new \ReflectionClass($val);
            if ($name === $class->getConstant('NAME')) {
                return $class->newInstanceArgs([$board]);
            }
        }

        throw new \InvalidArgumentException();
    }
}
