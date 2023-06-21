<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Termination;

/**
 * Recursive Annotation Variation.
 *
 * @license GPL
 */
class RAV extends AbstractMovetext
{
    private SAN $san;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        parent::__construct($move, $movetext);

        $this->san = new SAN($move, $movetext);
    }

    /**
     * Syntactic validation.
     *
     * @throws \Chess\Exception\UnknownNotationException
     * @return string
     */
    public function validate(): string
    {
        foreach ($this->moves as $move) {
            $this->move->validate($move);
        }

        return $this->movetext;
    }

    /**
     * Filters the movetext.
     *
     * @param string $movetext
     * @return string
     */
    protected function filter(string $movetext): string
    {
        // remove PGN symbols
        $movetext = str_replace(Termination::values(), '', $movetext);
        // remove comments
        $movetext = preg_replace("/\{[^)]+\}/", '', $movetext);
        // remove parentheses
        $movetext = preg_replace("/\(/", '', $movetext);
        $movetext = preg_replace("/\)/", '', $movetext);
        // replace FIDE notation with PGN notation
        $movetext = str_replace('0-0', 'O-O', $movetext);
        $movetext = str_replace('0-0-0', 'O-O-O', $movetext);
        // replace multiple spaces with a single space
        $movetext = preg_replace('/\s+/', ' ', $movetext);
        // remove space between dots
        $movetext = preg_replace('/\s\./', '.', $movetext);
        // remove space after dots
        $movetext = preg_replace('/\.\s/', '.', $movetext);

        return trim($movetext);
    }

    /**
     * Insert elements into the array of moves for further validation.
     *
     * @see \Chess\Play\RAV
     * @param string $movetext
     */
    protected function insert(string $movetext): void
    {
        foreach (explode(' ', $movetext) as $key => $val) {
            if (preg_match('/^[1-9][0-9]*\.\.\.(.*)$/', $val)) {
                $exploded = explode(Move::ELLIPSIS, $val);
                $this->moves[] = $exploded[1];
            } elseif (preg_match('/^[1-9][0-9]*\.(.*)$/', $val)) {
                $this->moves[] = explode('.', $val)[1];
            } else {
                $this->moves[] = $val;
            }
        }

        $this->moves = array_values(array_filter($this->moves));
    }

    /**
     * Returns the main variation.
     *
     * @return string
     */
    public function main(): string
    {
        $movetext = $this->san->validate();
        // remove ellipsis
        $movetext = preg_replace('/[1-9][0-9]*\.\.\./', '', $movetext);

        return $movetext;
    }
}
