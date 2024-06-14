<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board;

abstract class AbstractParagraph
{
    public Board $board;

    public array $paragraph = [];
}
