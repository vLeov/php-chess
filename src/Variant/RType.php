<?php

namespace Chess\Variant;

use Chess\Variant\Classical\PGN\AN\Castle;

class RType
{
    const CASTLE_SHORT = Castle::SHORT;
    const CASTLE_LONG = Castle::LONG;
    const PROMOTED = 'promoted';
    const SLIDER = 'slider';
}
