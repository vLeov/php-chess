<?php

namespace Chess\Tutor;

use Chess\FenHeuristics;
use Chess\ML\Supervised\Classification\CountLabeller;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;

class FenEvaluation extends AbstractParagraph
{
    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->paragraph = [
            ...(new FenExplanation($this->board))->getParagraph(),
            ...(new FenElaboration($this->board))->getParagraph(),
            ...$this->evaluate(),
        ];
    }

    private function evaluate(): array
    {
        $balance = (new FenHeuristics($this->board))->getBalance();
        $label = (new CountLabeller())->label($balance);
        $evaluation = "Overall, {$label[Color::W]} {$this->noun($label[Color::W])} {$this->verb($label[Color::W])} favoring White while {$label[Color::B]} {$this->verb($label[Color::B])} favoring Black.";

        return [
            $evaluation,
        ];
    }

    private function noun(int $total): string
    {
        $noun = $total === 1
            ? 'heuristic evaluation feature'
            : 'heuristic evaluation features';

        return $noun;
    }

    private function verb(int $total)
    {
        $verb = $total === 1 ? 'is' : 'are';

        return $verb;
    }
}
