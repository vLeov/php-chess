<?php

namespace Chess\Heuristic;

use Chess\Player;
use Chess\Evaluation\AttackEvaluation;
use Chess\Evaluation\CenterEvaluation;
use Chess\Evaluation\ConnectivityEvaluation;
use Chess\Evaluation\KingSafetyEvaluation;
use Chess\Evaluation\MaterialEvaluation;
use Chess\Evaluation\PressureEvaluation;
use Chess\Evaluation\SpaceEvaluation;
use Chess\Evaluation\SquareEvaluation;
use Chess\Evaluation\TacticsEvaluation;
use Chess\Evaluation\System;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

class HeuristicPicture extends Player
{
    protected $dimensions = [
        MaterialEvaluation::class => 20,
        CenterEvaluation::class => 20,
        ConnectivityEvaluation::class => 10,
        SpaceEvaluation::class => 10,
        PressureEvaluation::class => 10,
        KingSafetyEvaluation::class => 10,
        TacticsEvaluation::class => 10,
        AttackEvaluation::class => 10,
    ];

    protected $picture = [];

    public function getDimensions()
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): HeuristicPicture
    {
        $this->dimensions = $dimensions;

        return $this;
    }

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

    public function takeBalanced(): array
    {
        $balance = [];
        $pic = $this->take();
        foreach ($pic[Symbol::WHITE] as $i => $color) {
            foreach ($color as $j => $val) {
                $balance[$i][$j] = $pic[Symbol::WHITE][$i][$j] - $pic[Symbol::BLACK][$i][$j];
            }
        }

        return $balance;
    }

    public function sample(): array
    {
        $pic = $this->take();

        $this->sample = [
            Symbol::WHITE => end($pic[Symbol::WHITE]),
            Symbol::BLACK => end($pic[Symbol::BLACK]),
        ];

        return $this->sample;
    }

    protected function normalize()
    {
        $normalization = [];

        if (count($this->board->getHistory()) >= 2) {
            for ($i = 0; $i < count($this->dimensions); $i++) {
                $values = array_merge(
                    array_column($this->picture[Symbol::WHITE], $i),
                    array_column($this->picture[Symbol::BLACK], $i)
                );
                $min = min($values);
                $max = max($values);
                for ($j = 0; $j < count($this->picture[Symbol::WHITE]); $j++) {
                    if ($max - $min > 0) {
                        $normalization[Symbol::WHITE][$j][$i] = round(($this->picture[Symbol::WHITE][$j][$i] - $min) / ($max - $min), 2);
                        $normalization[Symbol::BLACK][$j][$i] = round(($this->picture[Symbol::BLACK][$j][$i] - $min) / ($max - $min), 2);
                    } elseif ($max == $min) {
                        $normalization[Symbol::WHITE][$j][$i] = round(1 / count($values), 2);
                        $normalization[Symbol::BLACK][$j][$i] = round(1 / count($values), 2);
                    }
                }
            }
        } else {
            $normalization[Symbol::WHITE][] = $normalization[Symbol::BLACK][] = array_fill(0, count($this->dimensions), 0.5);
        }

        $this->picture = $normalization;
    }
}
