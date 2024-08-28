<?php

namespace Chess;

abstract class AbstractFunction
{
    public function getEval(): array
    {
        return $this->eval;
    }

    public function names(): array
    {
        foreach ($this->eval as $val) {
            $names[] = (new \ReflectionClass($val))->getConstant('NAME');
        }

        return $names;
    }
}
