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
     * Validated movetext.
     *
     * @var string
     */
    protected string $validation;

    /**
     * Filtered movetext.
     *
     * @var string
     */
    protected string $filter;

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
     * Returns the validation string.
     *
     * @return string
     */
    public function getValidation(): string
    {
        return $this->validation;
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
     * Filtered movetext.
     *
     * @return string
     */
    abstract public function filter(): string;
}
