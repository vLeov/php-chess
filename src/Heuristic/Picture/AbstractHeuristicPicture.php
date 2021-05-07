<?php

namespace Chess\Heuristic\Picture;

use Chess\AbstractPicture;
use Chess\Evaluation\Value\System;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

class AbstractHeuristicPicture extends AbstractPicture
{
    /**
     * Takes a normalized, heuristic picture.
     *
     * @return array
     */
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $item = [];
            foreach ($this->dimensions as $dimension => $w) {
                $evald = (new $dimension($this->board))->evaluate(System::SYSTEM_BERLINER);
                is_array($evald[Symbol::WHITE])
                    ? $item[] = [
                        Symbol::WHITE => count($evald[Symbol::WHITE]),
                        Symbol::BLACK => count($evald[Symbol::BLACK])]
                    : $item[] = $evald;
            }
            $this->picture[Symbol::WHITE][] = array_column($item, Symbol::WHITE);
            $this->picture[Symbol::BLACK][] = array_column($item, Symbol::BLACK);
        }

        $this->normalize();

        return $this->picture;
    }
}
