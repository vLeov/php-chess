<?php

namespace Chess;

use Chess\Eval\InverseEvalInterface;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;

class FenHeuristics
{
    protected Board $board;

    protected StandardFunction $function;

    protected array $result;

    protected array $balance = [];

    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->function = new StandardFunction();

        $this->calc()->balance();
    }

    public function getBalance(): array
    {
        return $this->balance;
    }

    protected function calc(): FenHeuristics
    {
        foreach ($this->function->getEval() as $val) {
            $eval = new $val($this->board);
            $result = $eval->getResult();
            if (is_array($result[Color::W])) {
                if ($eval instanceof InverseEvalInterface) {
                    $item[] = [
                        Color::W => count($result[Color::B]),
                        Color::B => count($result[Color::W]),
                    ];
                } else {
                    $item[] = [
                        Color::W => count($result[Color::W]),
                        Color::B => count($result[Color::B]),
                    ];
                }
            } else {
                if ($eval instanceof InverseEvalInterface) {
                    $item[] = [
                        Color::W => $result[Color::B],
                        Color::B => $result[Color::W],
                    ];
                } else {
                    $item[] = $result;
                }
            }
        }

        $this->result[Color::W] = array_column($item, Color::W);
        $this->result[Color::B] = array_column($item, Color::B);

        return $this;
    }

    protected function balance(): FenHeuristics
    {
        foreach ($this->result[Color::W] as $key => $val) {
            $this->balance[$key] =
                round($this->result[Color::W][$key] - $this->result[Color::B][$key], 2);
        }

        return $this;
    }
}
