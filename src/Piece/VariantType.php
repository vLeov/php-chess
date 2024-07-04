<?php

namespace Chess\Piece;

class VariantType
{
    const CAPABLANCA = 'capablanca';

    const CLASSICAL = 'classical';

    public static function getClass(string $variant, string $name)
    {
        $namespace = ucfirst($variant);
        $class = "\\Chess\\Piece\\{$namespace}\\{$name}";
        if (class_exists($class)) {
            return $class;
        }

        return "\\Chess\\Piece\\Classical\\{$name}";
    }
}
