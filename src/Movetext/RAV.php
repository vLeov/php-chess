<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;

/**
 * Recursive Annotation Variation.
 *
 * @license GPL
 */
class RAV extends SAN
{
    /**
     * Returns the main variation.
     *
     * @return string
     */
    public function main(): string
    {
        return $this->validate();
    }

    /**
     * Filters the movetext for further processing.
     *
     * @param string $movetext
     * @return string
     */
    protected function filter(string $movetext): string
    {
        $movetext = parent::filter($movetext);
        // remove ellipsis
        $movetext = preg_replace('/[1-9][0-9]*\.\.\./', '', $movetext);

        return $movetext;
    }

    /**
     * Insert elements into the array of moves.
     *
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
}
