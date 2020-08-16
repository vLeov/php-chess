<?php

namespace PGNChess\Heuristic\Picture;

use PGNChess\Player;
use PGNChess\Evaluation\Value\System;
use PGNChess\Evaluation\Attack as AttackEvaluation;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\Evaluation\KingSafety as KingSafetyEvaluation;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

class Standard extends Player
{
    protected $picture = [];

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

    protected function normalize()
    {
        for ($i = 0; $i < count($this->picture[Symbol::WHITE][0]); $i++) {
            $values = array_merge(
                array_column($this->picture[Symbol::WHITE], $i),
                array_column($this->picture[Symbol::BLACK], $i)
            );
            $min = min($values);
            $max = max($values);
            if ($max - $min >= 0) {
                foreach ($this->picture[Symbol::WHITE] as $key => $val) {
                    $this->picture[Symbol::WHITE][$key][$i] = round(($val[$i] - $min) / ($max - $min), 2);
                }
                foreach ($this->picture[Symbol::BLACK] as $key => $val) {
                    $this->picture[Symbol::BLACK][$key][$i] = round(($val[$i] - $min) / ($max - $min), 2);
                }
            }
        }
    }
}
