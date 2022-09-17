<?php

namespace Chess\Variant\Chess960;

use Chess\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Chess960\StartPieces;
use Chess\Variant\Chess960\StartPosition;
use Chess\Variant\Chess960\Rule\CastlingRule;

final class Board extends ClassicalBoard
{
    public function __construct()
    {
        $this->castlingAbility = CastlingAbility::START;
        $startPosition = (new StartPosition())->create();
        $this->castlingRule = (new CastlingRule($startPosition))->getRule();
        $startPieces = (new StartPieces($this->castlingRule))->create();

        foreach ($startPieces as $piece) {
            $this->attach($piece);
        }
    }
}
