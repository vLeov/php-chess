<?php

namespace Chess\Variant\Chess960;

use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\PGN\AN\Square;
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
     * Start position.
     *
     * @var array
     */
    protected array $startPos;

    /**
     * Constructor.
     *
     * @param array $startPos
     */
    public function __construct(array $startPos)
    {
        $this->startPos = $startPos;
        $this->size = Square::SIZE;
        $this->castlingAbility = CastlingAbility::START;
        $this->castlingRule = (new CastlingRule($startPos))->getRule();
        $pieces = (new StartPieces($startPos))->create();
        foreach ($pieces as $piece) {
            $this->attach($piece);
        }

        $this->refresh();
    }

    /**
     * Returns the start position.
     *
     * @return array
     */
    public function getStartPos(): array
    {
        return $this->startPos;
    }
}
