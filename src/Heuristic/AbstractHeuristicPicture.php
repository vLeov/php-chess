<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\Evaluation\Value\System;
use Chess\Evaluation\Pressure as PressureEvaluation;
use Chess\Evaluation\Pressured as PressuredEvaluation;
use Chess\Evaluation\Center as CenterEvaluation;
use Chess\Evaluation\Connectivity as ConnectivityEvaluation;
use Chess\Evaluation\KingSafety as KingSafetyEvaluation;
use Chess\Evaluation\Material as MaterialEvaluation;
use Chess\Evaluation\Space as SpaceEvaluation;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

abstract class AbstractHeuristicPicture extends AbstractPicture
{
    const DIMENSIONS = [
        MaterialEvaluation::class,
        KingSafetyEvaluation::class,
        PressuredEvaluation::class,
        CenterEvaluation::class,
        ConnectivityEvaluation::class,
        SpaceEvaluation::class,
        PressureEvaluation::class,
    ];

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
            foreach (self::DIMENSIONS as $dimension) {
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

    abstract public function evaluate(): array;
}
