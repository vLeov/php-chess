<?php

namespace Chess\PGN;

use Chess\Exception\UnknownNotationException;
use Chess\PGN\Symbol;
use Chess\PGN\Validate;

class Movetext
{
    private $text;

    private $movetext;

    public function __construct(string $text)
    {
        $this->text = $text;

        $this->movetext = (object) [
            'n' => [],
            'move' => [],
        ];

        $this->build();
    }

    public function validate()
    {
        if (!$this->areConsecutiveNumbers()) {
            return false;
        }
        foreach ($this->movetext->move as $move) {
            if ($move !== Symbol::RESULT_WHITE_WINS &&
                $move !== Symbol::RESULT_BLACK_WINS &&
                $move !== Symbol::RESULT_DRAW &&
                $move !== Symbol::RESULT_UNKNOWN
               ) {
                try {
                    Validate::move($move);
                } catch (UnknownNotationException $e) {
                    return false;
                }
            }
        }

        return $this->filter();
    }

    /**
     * Filters the movetext.
     *
     *      Example:
     *
     *          1.e4  e5 2.  f4 exf4 3. Bc4 d5 4.Bxd5 Qh4+
     *
     *      is filtered this way:
     *
     *          1.e4 e5 2.f4 exf4 3.Bc4 d5 4.Bxd5 Qh4+
     *
     * @return mixed bool|string true if the movetext is valid; otherwise the filtered movetext
     */
    protected function filter()
    {
        $filtered = '';
        for ($i = 0; $i < count($this->movetext->n); $i++) {
            $filtered .= $this->movetext->n[$i] . '.' . $this->movetext->move[$i*2] . ' ';
            if (isset($this->movetext->move[$i*2+1])) {
                $filtered .= $this->movetext->move[$i*2+1] . ' ';
            }
        }

        return trim($filtered);
    }

    protected function build()
    {
        // remove comments
        $text = preg_replace("/\{[^)]+\}/", '', $this->text);
        // remove spaces between dots
        $text = preg_replace('/\s+\./', '.', $text);
        $moves = array_filter(explode(' ', $text));
        foreach ($moves as $move) {
            if (preg_match('/^[1-9][0-9]*\.(.*)$/', $move)) {
                $exploded = explode('.', $move);
                $this->movetext->n[] = $exploded[0];
                $this->movetext->move[] = $exploded[1];
            } else {
                $this->movetext->move[] = $move;
            }
        }

        $this->movetext->move = array_values(array_filter($this->movetext->move));
    }

    protected function areConsecutiveNumbers(): bool
    {
        $areConsecutiveNumbers = 1;
        for ($i = 0; $i < count($this->movetext->n); $i++) {
            $areConsecutiveNumbers *= (int) $this->movetext->n[$i] == $i + 1;
        }

        return (bool) $areConsecutiveNumbers;
    }
}
