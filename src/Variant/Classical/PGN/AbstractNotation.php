<?php

namespace Chess\Variant\Classical\PGN;

abstract class AbstractNotation
{
    public function values(): array
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }
}
