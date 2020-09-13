<?php

namespace PGNChess\Heuristic\Picture;

use PGNChess\AbstractPicture;
use PGNChess\Evaluation\Value\System;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class Standard extends AbstractPicture
{
    const N_DIMENSIONS = 5;

    /**
     * Takes a normalized, heuristic picture.
     *
     * e.g.
     *
     *      Array
     *      (
     *          [w] => Array
     *              (
     *                  [0] => Array
     *                      (
     *                          [0] => 0
     *                          [1] => 0.54
     *                          [2] => 0
     *                          [3] => 0
     *                          [4] => 1
     *                      )
     *
     *                  [1] => Array
     *                      (
     *                          [0] => 0.25
     *                          [1] => 0.54
     *                          [2] => 1
     *                          [3] => 0.25
     *                          [4] => 1
     *                      )
     *      ...
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

            $attEvald = (new AttackEvaluation($this->board))->evaluate();
            $connEvald = (new ConnectivityEvaluation($this->board))->evaluate();
            $ctrEvald = (new CenterEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
            $kSafetyEvald = (new KingSafetyEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);
            $mtlEvald = (new MaterialEvaluation($this->board))->evaluate(System::SYSTEM_BERLINER);

            $this->picture[Symbol::WHITE][] = [
                count($attEvald[Symbol::WHITE]),
                $connEvald[Symbol::WHITE],
                $ctrEvald[Symbol::WHITE],
                $kSafetyEvald[Symbol::WHITE],
                $mtlEvald[Symbol::WHITE],
            ];

            $this->picture[Symbol::BLACK][] = [
                count($attEvald[Symbol::BLACK]),
                $connEvald[Symbol::BLACK],
                $ctrEvald[Symbol::BLACK],
                $kSafetyEvald[Symbol::BLACK],
                $mtlEvald[Symbol::BLACK],
            ];
        }

        $this->normalize();

        return $this->picture;
    }
}
