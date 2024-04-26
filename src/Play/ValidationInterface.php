<?php

namespace Chess\Play;

interface ValidationInterface
{
    /**
     * Semantically validated movetext.
     *
     * Makes the moves in a movetext.
     *
     * @throws \Chess\Exception\PlayException
     * @return AbstractPlay
     */
     public function validate(): AbstractPlay;
}
