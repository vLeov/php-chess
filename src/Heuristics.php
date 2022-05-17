<?php

namespace Chess;

use Chess\Evaluation\InverseEvaluationInterface;
use Chess\PGN\AN\Color;

class Heuristics extends Player
{
    use HeuristicsTrait;

    public function __construct(string $movetext = '', Board $board = null)
    {
        parent::__construct($movetext, $board);

        $this->calc();
    }

    /**
     * Returns the dimensions names.
     *
     * @return array
     */
    public function getDimensionsNames(): array
    {
        $dimensionsNames = [];
        foreach ($this->dimensions as $key => $val) {
            $dimensionsNames[] = (new \ReflectionClass($key))
                ->getConstant('NAME');
        }

        return $dimensionsNames;
    }

    /**
     * Returns the current evaluation of $this->board.
     *
     * The result obtained suggests which player may be better.
     *
     * @return array
     */
    public function eval(): array
    {
        $result = [
            Color::W => 0,
            Color::B => 0,
        ];

        $weights = array_values($this->getDimensions());

        $pic = $this->getResult();

        for ($i = 0; $i < count($this->getDimensions()); $i++) {
            $result[Color::W] += $weights[$i] * end($pic[Color::W])[$i];
            $result[Color::B] += $weights[$i] * end($pic[Color::B])[$i];
        }

        $result[Color::W] = round($result[Color::W], 2);
        $result[Color::B] = round($result[Color::B], 2);

        return $result;
    }

    /**
     * Returns the resized balanced heuristics given a new range of values.
     *
     * @param float $newMin
     * @param float $newMax
     * @return array
     */
    public function getResizedBalance(float $newMin, float $newMax): array
    {
        $oldMin = -1;
        $oldMax = 1;
        $resize = [];
        foreach ($this->balance as $key => $val) {
            foreach ($val as $v) {
                $resized = (($v - $oldMin) / ($oldMax - $oldMin)) *
                    ($newMax - $newMin) + $newMin;
                $resize[$key][] = round($resized, 2);
            }
        }

        return $resize;
    }

    /**
     * Heuristics calc.
     *
     * @return \Chess\Heuristics
     */
    protected function calc(): Heuristics
    {
        foreach ($this->moves as $key => $val) {
            if ($key % 2 === 0) {
                $item = [];
                $this->board->play(Color::W, $this->moves[$key]);
                empty($this->moves[$key+1])
                    ?: $this->board->play(Color::B, $this->moves[$key+1]);
                foreach ($this->dimensions as $className => $weight) {
                    $dimension = new $className($this->board);
                    $eval = $dimension->eval();
                    if (is_array($eval[Color::W])) {
                        if ($dimension instanceof InverseEvaluationInterface) {
                            $item[] = [
                                Color::W => count($eval[Color::B]),
                                Color::B => count($eval[Color::W]),
                            ];
                        } else {
                            $item[] = [
                                Color::W => count($eval[Color::W]),
                                Color::B => count($eval[Color::B]),
                            ];
                        }
                    } else {
                        if ($dimension instanceof InverseEvaluationInterface) {
                            $item[] = [
                                Color::W => $eval[Color::B],
                                Color::B => $eval[Color::W],
                            ];
                        } else {
                            $item[] = $eval;
                        }
                    }
                }
                $this->result[Color::W][] = array_column($item, Color::W);
                $this->result[Color::B][] = array_column($item, Color::B);
            }
        }
        $this->normalize()->balance();

        return $this;
    }

    /**
     * Normalizes the heuristic picture of $this->board.
     *
     * The dimensions are normalized meaning that the chess features (Material,
     * Center, Connectivity, Space, Pressure, King safety, Tactics, and so on)
     * are evald and scaled to have values between 0 and 1.
     *
     * It is worth noting that a normalized heuristic picture changes with every
     * chess move that is made because it is recalculated or zoomed out, if you like,
     * to fit within a 0–1 range.
     *
     * @return \Chess\Heuristics
     */
    protected function normalize(): Heuristics
    {
        $normalization = [];

        if (count($this->board->getHistory()) >= 2) {
            for ($i = 0; $i < count($this->dimensions); $i++) {
                $values = [
                    ...array_column($this->result[Color::W], $i),
                    ...array_column($this->result[Color::B], $i)
                ];
                $min = round(min($values), 2);
                $max = round(max($values), 2);
                for ($j = 0; $j < count($this->result[Color::W]); $j++) {
                    if ($max - $min > 0) {
                        $normalization[Color::W][$j][$i] =
                            round(($this->result[Color::W][$j][$i] - $min) / ($max - $min), 2);
                        $normalization[Color::B][$j][$i] =
                            round(($this->result[Color::B][$j][$i] - $min) / ($max - $min), 2);
                    } elseif ($max == $min) {
                        $normalization[Color::W][$j][$i] = 0;
                        $normalization[Color::B][$j][$i] = 0;
                    }
                }
            }
        } else {
            $normalization[Color::W][] =
                $normalization[Color::B][] = array_fill(0, count($this->dimensions), 0);
        }

        $this->result = $normalization;

        return $this;
    }

    /**
     * Balances the heuristic picture of $this->board.
     *
     * A chess game can be plotted in terms of balance. +1 is the best possible
     * evaluation for White and -1 the best possible evaluation for Black. Both
     * forces being set to 0 means they're actually offset and, therefore, balanced.
     *
     * @return \Chess\Heuristics
     */
    protected function balance(): Heuristics
    {
        foreach ($this->result[Color::W] as $i => $color) {
            foreach ($color as $j => $val) {
                $this->balance[$i][$j] =
                    round($this->result[Color::W][$i][$j] - $this->result[Color::B][$i][$j], 2);
            }
        }

        return $this;
    }

    /**
     * Returns the last element of the heuristic picture.
     *
     * @return array
     */
    public function end(): array
    {
        return [
            Color::W => end($this->result[Color::W]),
            Color::B => end($this->result[Color::B]),
        ];
    }
}
