<?php

namespace Chess\Tutor;

use Chess\FenHeuristics;
use Chess\Function\AbstractFunction;
use Chess\ML\Supervised\Classification\CountLabeller;
use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;

class FenEvaluation extends AbstractParagraph
{
    public function __construct(AbstractFunction $function, AbstractBoard $board)
    {
        $this->function = $function;

        $this->board = $board;

        $this->paragraph = [
            ...(new FenExplanation($this->function, $this->board))->paragraph,
            ...(new FenElaboration($this->function, $this->board))->paragraph,
            ...$this->evaluate(),
        ];
    }

    private function evaluate(): array
    {
        $balance = (new FenHeuristics($this->function, $this->board))->getBalance();
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
