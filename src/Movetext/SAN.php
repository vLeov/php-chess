<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Termination;

/**
 * Standard Algebraic Notation.
 *
 * @license GPL
 */
class SAN extends AbstractMovetext
{
    /**
     * First move.
     *
     * @var int
     */
    protected int $first;

    /**
     * Last move.
     *
     * @var int
     */
    protected int $last;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        parent::__construct($move, $movetext);
        
        $this->first();
        $this->last();
    }

    /**
     * Returns the first move.
     *
     * @return int
     */
    public function getFirst(): int
    {
        return $this->first;
    }

    /**
     * Returns the last move.
     *
     * @return int
     */
    public function getLast(): int
    {
        return $this->last;
    }

    /**
     * Before inserting into the array of moves.
     *
     * @return string
     */
    protected function beforeInsert(): string
    {
        // remove comments
        $movetext = preg_replace("/\{[^)]+\}/", '', $this->filter());
        // replace multiple spaces with a single space
        $movetext = preg_replace('/\s+/', ' ', $movetext);

        return trim($movetext);
    }

    /**
     * Insert elements into the array of moves for further validation.
     *
     * @see \Chess\Play\SAN
     */
    protected function insert(): void
    {
        foreach (explode(' ', $this->validation) as $key => $val) {
            if ($key === 0) {
                if (preg_match('/^[1-9][0-9]*\.\.\.(.*)$/', $val)) {
                    $exploded = explode(Move::ELLIPSIS, $val);
                    $this->moves[] = Move::ELLIPSIS;
                    $this->moves[] = $exploded[1];
                } elseif (preg_match('/^[1-9][0-9]*\.(.*)$/', $val)) {
                    $this->moves[] = explode('.', $val)[1];
                } else {
                    $this->moves[] = $val;
                }
            } else {
                if (preg_match('/^[1-9][0-9]*\.(.*)$/', $val)) {
                    $this->moves[] = explode('.', $val)[1];
                } else {
                    $this->moves[] = $val;
                }
            }
        }

        $this->moves = array_values(array_filter($this->moves));
    }

    /**
     * Calculates the first move.
     */
    protected function first(): void
    {
        $exploded = explode(' ', $this->validation);
        $first = $exploded[0];
        $exploded = explode('.', $first);

        $this->first = intval($exploded[0]);
    }

    /**
     * Calculates the last move.
     */
    protected function last(): void
    {
        $exploded = explode(' ', $this->validation);
        $last = end($exploded);
        $exploded = explode('.', $last);

        $this->last = intval($exploded[0]);
    }

    /**
     * Syntactically validated movetext.
     *
     * @throws \Chess\Exception\UnknownNotationException
     * @return string
     */
    public function validate(): string
    {
        foreach ($this->moves as $move) {
            if ($move !== Move::ELLIPSIS) {
                $this->move->validate($move);
            }
        }

        return $this->validation;
    }

    /**
     * Filtered movetext.
     *
     * @return string
     */
    public function filter(): string
    {
        // remove PGN symbols
        $movetext = str_replace(Termination::values(), '', $this->movetext);
        // remove variations
        $movetext = preg_replace('/\(([^()]|(?R))*\)/', '', $movetext);
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
     * Returns an array representing the movetext as a sequence of moves.
     *
     * e.g. 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+
     *
     * Array
     * (
     *     [0] => 1.d4 Nf6
     *     [1] => 1.d4 Nf6 2.Nf3 e6
     *     [2] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+
     * )
     *
     * @return array
     */
    public function sequence(): array
    {
        $n = floor(count($this->moves) / 2);
        $sequence = [];
        for ($i = 0; $i < $n; $i++) {
            $j = 2 * $i;
            if (isset($this->moves[$j+1])) {
                $item = end($sequence) . ' ' .  $i + 1 .
                ".{$this->moves[$j]} {$this->moves[$j+1]}";
                $sequence[] = trim($item);
            }
        }

        return $sequence;
    }
}
