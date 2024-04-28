<?php

namespace Chess\Tutor;

use Chess\Heuristics\FenHeuristics;
use Chess\ML\Supervised\Classification\CountLabeller;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * FenEvaluation
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class FenEvaluation
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    private ClassicalBoard $board;

    /**
     * Paragraph.
     *
     * @var array
     */
    private array $paragraph = [];

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(ClassicalBoard $board)
    {
        $this->board = $board;

        $this->paragraph = [
            ...(new FenExplanation($this->board))->getParagraph(),
            ...(new FenElaboration($this->board))->getParagraph(),
            ...$this->evaluate(),
        ];
    }

    /**
     * Returns the board.
     *
     * @return \Chess\Variant\Classical\Board
     */
    public function getBoard(): ClassicalBoard
    {
        return $this->board;
    }

    /**
     * Returns the paragraph.
     *
     * @return array
     */
    public function getParagraph(): array
    {
        return $this->paragraph;
    }

    /**
     * Returns the position evaluation.
     *
     * @return array
     */
    private function evaluate(): array
    {
        $balance = (new FenHeuristics($this->board))->getBalance();
        $label = (new CountLabeller())->label($balance);
        $evaluation = "Overall, {$label[Color::W]} {$this->noun($label[Color::W])} {$this->verb($label[Color::W])} favoring White while {$label[Color::B]} {$this->verb($label[Color::B])} favoring Black.";

        return [
            $evaluation,
        ];
    }

    /**
     * Decline the noun.
     *
     * @param int $total     *
     * @return string
     */
    private function noun(int $total): string
    {
        $noun = $total === 1
            ? 'heuristic evaluation feature'
            : 'heuristic evaluation features';

        return $noun;
    }

    /**
     * Decline the verb.
     *
     * @param int $total     *
     * @return string
     */
    private function verb(int $total)
    {
        $verb = $total === 1 ? 'is' : 'are';

        return $verb;
    }
}
