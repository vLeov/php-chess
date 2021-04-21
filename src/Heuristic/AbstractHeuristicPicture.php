<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\Evaluation\Value\System;
use Chess\Evaluation\Attack as AttackEvaluation;
use Chess\Evaluation\Center as CenterEvaluation;
use Chess\Evaluation\Connectivity as ConnectivityEvaluation;
use Chess\Evaluation\KingSafety as KingSafetyEvaluation;
use Chess\Evaluation\Material as MaterialEvaluation;
use Chess\Evaluation\Space as SpaceEvaluation;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

abstract class AbstractHeuristicPicture extends AbstractPicture
{
    const N_DIMENSIONS = 6;

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

            $mtlEvald = (new MaterialEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
            $kSafetyEvald = (new KingSafetyEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
            $ctrEvald = (new CenterEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
            $connEvald = (new ConnectivityEvaluation($this->board))->evaluate();
            $spaceEvald = (new SpaceEvaluation($this->board))->evaluate();
            $attEvald = (new AttackEvaluation($this->board))->evaluate();

            $this->picture[Symbol::WHITE][] = [
                $mtlEvald[Symbol::WHITE] - $mtlEvald[Symbol::BLACK],
                $kSafetyEvald[Symbol::WHITE],
                $ctrEvald[Symbol::WHITE],
                $connEvald[Symbol::WHITE],
                count($spaceEvald[Symbol::WHITE]),
                count($attEvald[Symbol::WHITE]),
            ];

            $this->picture[Symbol::BLACK][] = [
                $mtlEvald[Symbol::BLACK] - $mtlEvald[Symbol::WHITE],
                $kSafetyEvald[Symbol::BLACK],
                $ctrEvald[Symbol::BLACK],
                $connEvald[Symbol::BLACK],
                count($spaceEvald[Symbol::BLACK]),
                count($attEvald[Symbol::BLACK]),
            ];
        }

        $this->normalize();

        return $this->picture;
    }

    abstract public function evaluate(): array;
}
