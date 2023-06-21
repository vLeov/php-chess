<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\AN\Termination;
use Chess\Variant\Classical\PGN\Move;

/**
 * Standard Algebraic Notation.
 *
 * @license GPL
 */
class SAN
{
    const SYMBOL_ELLIPSIS = '...';

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
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        $this->move = $move;
        $this->movetext = $this->filter($movetext);
        $this->moves = [];
        $this->fill($this->movetext);
    }

    /**
     * Returns the array of PGN moves.
     *
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * Validation.
     *
     * @return string
     */
    public function validate(): string
    {
        foreach ($this->moves as $move) {
            if ($move !== self::SYMBOL_ELLIPSIS) {
                $this->move->validate($move);
            }
        }

        return $this->movetext;
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

    /**
     * Filters the movetext for further processing.
     *
     * @param string $movetext
     */
    protected function filter(string $movetext): string
    {
        // remove PGN symbols
        $movetext = str_replace(Termination::values(), '', $movetext);
        // remove comments
        $movetext = preg_replace("/\{[^)]+\}/", '', $movetext);
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
     * Fills the array of PGN moves.
     *
     * @param string $movetext
     */
    protected function fill(string $movetext): void
    {
        foreach (explode(' ', $movetext) as $key => $val) {
            if ($key === 0) {
                if (preg_match('/^[1-9][0-9]*\.\.\.(.*)$/', $val)) {
                    $exploded = explode(self::SYMBOL_ELLIPSIS, $val);
                    $this->moves[] = self::SYMBOL_ELLIPSIS;
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
}
