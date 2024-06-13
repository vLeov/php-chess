<?php

namespace Chess;

use Chess\Variant\Classical\Board;

class EvalFactory
{
    public static function create(string $name, Board $board)
    {
        foreach ((new StandardFunction())->getEval() as $val) {
            $class = new \ReflectionClass($val);
            if ($name === $class->getConstant('NAME')) {
                return $class->newInstanceArgs([$board]);
            }
        }

        throw new \InvalidArgumentException();
    }
}
