<?php

namespace Chess\Variant\Chess960;

use Chess\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Chess960\StartPieces;
use Chess\Variant\Chess960\Rule\CastlingRule;

final class Board extends ClassicalBoard
{
    public function __construct(array $startPosition)
    {
        $this->castlingRule = (new CastlingRule($startPosition))->getRule();

        $pieces = (new StartPieces($startPosition, $this->castlingRule))->create();

        foreach ($pieces as $piece) {
            $this->attach($piece);
        }

        $this->castlingAbility = CastlingAbility::START;

        $this->refresh();
    }

    public function getCastlingRule(): array
    {
        return $this->castlingRule;
    }

    public function getCastlingAbility(): string
    {
        return $this->castlingAbility;
    }
}
