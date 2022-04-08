<?php

namespace Chess\PGN;

use Chess\Exception\MovetextException;
use Chess\Exception\UnknownNotationException;
use Chess\PGN\Symbol;
use Chess\PGN\Validate;

/**
 * Movetext.
 *
 * Provides with functionality to parse and process a PGN movetext.
 *
 * @license GPL
 */
class Movetext
{
    /**
     * PGN symbols to be filtered.
     *
     * @var array
     */
    const FILTER  = [
        Symbol::RESULT_WHITE_WINS,
        Symbol::RESULT_BLACK_WINS,
        Symbol::RESULT_DRAW,
        Symbol::RESULT_UNKNOWN,
    ];

    /**
     * The movetext.
     *
     * @var object
     */
    private $movetext;

    public function __construct(string $text)
    {
        $this->movetext = (object) [
            'n' => [],
            'moves' => [],
        ];

        $this->filter($text);
    }

    /**
     * Returns the movetext.
     *
     * @return object
     */
    public function getMovetext(): object
    {
        return $this->movetext;
    }

    /**
     * Validates the movetext.
     *
     * @return string
     */
    public function validate(): string
    {
        if (!$this->isOrdered()) {
            throw new MovetextException;
        }

        foreach ($this->movetext->moves as $move) {
            Validate::move($move);
        }

        return $this->join();
    }

    /**
     * Concatenates the moves to form a string.
     *
     * @return string
     */
    protected function join(): string
    {
        $text = '';
        foreach ($this->movetext->moves as $key => $val) {
            if ($key === 0) {
                $text .= "1.{$this->movetext->moves[0]} ";
            } else if ($key === 1) {
                $text .= "{$this->movetext->moves[1]} ";
            } elseif ($key % 2 === 0) {
                $n = $key - ($key / 2) + 1;
                $text .= "$n.{$this->movetext->moves[$key]} ";
            } else {
                $text .= "{$this->movetext->moves[$key]} ";
            }
        }

        return trim($text);
    }

    /**
     * Filters the given text for further processing.
     *
     * @param string
     */
    protected function filter(string $text)
    {
        // remove the PGN symbols found in the filter
        $text = str_replace(self::FILTER, '', $text);

        // remove comments
        $text = preg_replace("/\{[^)]+\}/", '', $text);
        $text = preg_replace("/\([^)]+\)/", '', $text);

        // replace fide long castle
        $text = preg_replace("/0-0/", 'O-O', $text);

        // replace fide short castle
        $text = preg_replace("/0-0-0/", 'O-O-O', $text);

        // remove spaces between dots
        $text = preg_replace('/\s+\./', '.', $text);

        // build the array of moves
        foreach ($moves = explode(' ', $text) as $move) {
            if (preg_match('/^[1-9][0-9]*\.(.*)$/', $move)) {
                $exploded = explode('.', $move);
                $this->movetext->n[] = $exploded[0];
                $this->movetext->moves[] = $exploded[1];
            } else {
                $this->movetext->moves[] = $move;
            }
        }

        $this->movetext->moves = array_values(array_filter($this->movetext->moves));
    }

    /**
     * Finds out if the movetext is ordered.
     *
     * @return bool
     */
    protected function isOrdered(): bool
    {
        $isOrdered = 1;
        for ($i = 0; $i < count($this->movetext->n); $i++) {
            $isOrdered *= (int) $this->movetext->n[$i] == $i + 1;
        }

        return (bool) $isOrdered;
    }

    /**
     * Returns an array representing the movetext as a sequence of moves.
     *
     * e.g. 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5
     *
     * Array
     * (
     *  [0] => 1.d4 Nf6
     *  [1] => 1.d4 Nf6 2.Nf3 e6
     *  [2] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+
     *  [3] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O
     *  [4] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7
     *  [5] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6
     *  [6] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5
     * )
     *
     * @return array
     */
    public function sequence(): array
    {
        $sequence = [];
        for ($i = 0; $i < count($this->movetext->n); $i++) {
            $j = 2 * $i;
            if (isset($this->movetext->moves[$j+1])) {
                $item = end($sequence) .
                    " {$this->movetext->n[$i]}.{$this->movetext->moves[$j]} {$this->movetext->moves[$j+1]}";
                $sequence[] = trim($item);
            }
        }

        return $sequence;
    }
}
