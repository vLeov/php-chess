<?php

namespace Chess\Movetext;

/**
 * Recursive Annotation Variation.
 *
 * @license GPL
 */
class RAV extends SAN
{
    public function getMain()
    {
        return $this->validate();
    }
}
