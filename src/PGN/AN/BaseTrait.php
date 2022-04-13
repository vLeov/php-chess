<?php

namespace Chess\PGN\AN;

/**
 * Base trait.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
trait BaseTrait
{
    public static function values(): array
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }
}
