<?php

namespace Chess\Variant\Capablanca80\FEN;

use Chess\Variant\Classical\FEN\AbstractStrToPgn;

/**
 * Converts a short FEN string into PGN move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class ShortStrToPgn extends AbstractStrToPgn
{
    public function __construct(string $fromFen, string $toFen)
    {
        $this->board = (new StrToBoard($fromFen))->create();

        parent::__construct($fromFen, $toFen);
    }

    protected function find(array $legal): ?string
    {
        foreach ($legal as $key => $val) {
            if (str_starts_with(current($val), $this->toFen)) {
                return key($val);
            }
        }

        return null;
    }
}
