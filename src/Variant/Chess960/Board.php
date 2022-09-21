<?php

namespace Chess\Variant\Chess960;

use Chess\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Chess960\StartPieces;
use Chess\Variant\Chess960\Rule\CastlingRule;

/**
 * Board
 *
 * Chess board representation that allows to play a game of chess 960 in Portable
 * Game Notation (PGN) format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
final class Board extends ClassicalBoard
{
    /**
     * Constructor.
     *
     * @param array $startPosition
     */
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

    /**
     * Returns the castling rule.
     *
     * @return array
     */
    public function getCastlingRule(): array
    {
        return $this->castlingRule;
    }

    /**
     * Returns the castling ability.
     *
     * @return array
     */
    public function getCastlingAbility(): string
    {
        return $this->castlingAbility;
    }
}
