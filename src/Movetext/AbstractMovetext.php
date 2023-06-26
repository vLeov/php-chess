<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;

/**
 * AbstractMovetext.
 *
 * @license GPL
 */
abstract class AbstractMovetext
{
    /**
     * Move.
     *
     * @var \Chess\Variant\Classical\PGN\Move
     */
    protected Move $move;

    /**
     * Movetext.
     *
     * @var string
     */
    protected string $movetext;

    /**
     * Array of PGN moves.
     *
     * @var array
     */
    protected array $moves;

    /**
     * Syntactically validated movetext.
     *
     * The syntactically validated movetext does not contain any comments or
     * parentheses.
     *
     * @var string
     */
    protected string $validated;

    /**
     * Inline movetext.
     *
     * The inline movetext contains comments and parentheses.
     *
     * @var string
     */
    protected string $inline;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        $this->move = $move;
        $this->movetext = $movetext;
        $this->moves = [];

        $this->beforeInsert()->insert();
    }

    /**
     * Returns the move.
     *
     * @return \Chess\Variant\Classical\PGN\Move
     */
    public function getMove(): Move
    {
        return $this->move;
    }

    /**
     * Returns the movetext.
     *
     * @return string
     */
    public function getMovetext(): string
    {
        return $this->movetext;
    }

    /**
     * Returns the array of moves.
     *
     * @see \Chess\Play\RAV
     * @see \Chess\Play\SAN
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * Before inserting elements into the array of moves.
     *
     * @return \Chess\Movetext\AbstractMovetext
     */
    abstract protected function beforeInsert(): AbstractMovetext;

    /**
     * Insert elements into the array of moves.
     */
    abstract protected function insert(): void;

    /**
     * Syntactically validated movetext.
     *
     * @throws \Chess\Exception\UnknownNotationException
     * @return string
     */
    abstract public function validate(): string;

    /**
     * Inline notation.
     *
     * @return string
     */
    abstract public function inline(): string;
}
