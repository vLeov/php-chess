<?php

namespace Chess\Tutor;

use Chess\Variant\AbstractBoard;

abstract class AbstractParagraph
{
    public AbstractBoard $board;

    public array $paragraph = [];
}
