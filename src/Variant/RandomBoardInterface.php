<?php

namespace Chess\Variant;

interface RandomBoardInterface
{
    /**
     * Returns the start position.
     *
     * @return array
     */
    public function getStartPos(): array;
}
