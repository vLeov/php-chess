<?php

namespace Chess\Variant\Classical\Randomizer\Endgame;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Randomizer\Randomizer;

class PawnEndgameRandomizer extends Randomizer
{
    public function __construct(string $turn)
    {
        $items = [
            $turn => ['P'],
        ];

        do {
            parent::__construct($turn, $items);
            foreach ($this->board->getPieces() as $piece) {
                if ($piece->getId() === 'P') {
                    $ranks = $piece->getRanks();
                }
            }
        } while (
            $turn === Color::W && ($ranks->next === 2 || $ranks->next === 9) ||
            $turn === Color::B && ($ranks->next === 7 || $ranks->next === 0)
        );
    }
}
