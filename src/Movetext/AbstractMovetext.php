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
        $this->validation = $this->beforeInsert($movetext);
        $this->insert($this->validation);
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
     * Before inserting moves into the array.
     *
     * @param string $movetext
     */
    abstract protected function beforeInsert(string $movetext): string;

    /**
     * Insert elements into the array of moves.
     *
     * @param string $movetext
     */
    abstract protected function insert(string $movetext): void;

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
