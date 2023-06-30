<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Termination;

/**
 * Standard Algebraic Notation.
 *
 * @license GPL
 */
class SanMovetext extends AbstractMovetext
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
     * Starting turn.
     *
     * @var string
     */
    protected string $startTurn = '';

    /**
     * Current turn.
     *
     * @var string
     */
    protected string $turn = '';

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
        $this->startTurn();
        $this->turn();
    }

    /**
     * Returns the move number that the movetext starts with.
     *
     * @return int
     */
    public function getFirst(): int
    {
        return $this->first;
    }

    /**
     * Returns the move number that the movetext ends with.
     *
     * @return int
     */
    public function getLast(): int
    {
        return $this->last;
    }

    /**
     * Returns the starting turn.
     *
     * @return string
     */
    public function getStartTurn(): string
    {
        return $this->startTurn;
    }

    /**
     * Returns the current turn.
     *
     * @return string
     */
    public function getTurn(): string
    {
        return $this->turn;
    }

    /**
     * Before inserting elements into the array of moves.
     *
     * @return \Chess\Movetext\SanMovetext
     */
    protected function beforeInsert(): SanMovetext
    {
        // remove comments
        $str = preg_replace('(\{.*?\})', '', $this->filtered());
        // replace multiple spaces with a single space
        $str = preg_replace('/\s+/', ' ', $str);

        $this->validated = trim($str);

        return $this;
    }

    /**
     * Insert elements into the array of moves for further validation.
     *
     * @see \Chess\Play\SanPlay
     */
    protected function insert(): void
    {
        foreach (explode(' ', $this->validated) as $key => $val) {
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
        $exploded = explode(' ', $this->validated);
        $first = $exploded[0];
        $exploded = explode('.', $first);

        $this->first = intval($exploded[0]);
    }

    /**
     * Calculates the last move.
     */
    protected function last(): void
    {
        $exploded = explode(' ', $this->validated);
        $last = end($exploded);
        if (str_contains($last, '.')) {
            $exploded = explode('.', $last);
        } else {
            $last = prev($exploded);
            $exploded = explode('.', $last);
        }

        $this->last = intval($exploded[0]);
    }

    /**
     * Calculates the starting turn.
     */
    protected function startTurn(): void
    {
        if (preg_match('/^[1-9][0-9]*\.\.\.(.*)$/', $this->validated)) {
            $this->startTurn = Color::B;
        } else {
            $this->startTurn = Color::W;
        }
    }

    /**
     * Calculates the current turn.
     */
    protected function turn(): void
    {
        $exploded = explode(' ', $this->validated);
        $last = end($exploded);
        if (str_contains($last, '.')) {
            $this->turn = Color::B;
        } else {
            $this->turn = Color::W;
        }
    }

    /**
     * Syntactically validated movetext.
     *
     * The syntactically validated movetext does not contain any comments or
     * parentheses.
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

        return $this->validated;
    }

    /**
     * Filtered movetext.
     *
     * The filtered movetext contains comments and parentheses.
     *
     * @return string
     */
    public function filtered(): string
    {
        // remove PGN symbols
        $str = str_replace(Termination::values(), '', $this->movetext);
        // remove variations
        $str = preg_replace('/\(([^()]|(?R))*\)/', '', $str);
        // replace FIDE notation with PGN notation
        $str = str_replace('0-0', 'O-O', $str);
        $str = str_replace('0-0-0', 'O-O-O', $str);
        // replace multiple spaces with a single space
        $str = preg_replace('/\s+/', ' ', $str);
        // remove space between dots
        $str = preg_replace('/\s\./', '.', $str);
        // remove space after dots
        $str = preg_replace('/\.\s/', '.', $str);

        return trim($str);
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
