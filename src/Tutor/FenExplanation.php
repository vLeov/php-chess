<?php

namespace Chess\Tutor;

use Chess\Function\StandardFunction;
use Chess\Heuristics\FenHeuristics;
use Chess\ML\Supervised\Classification\CountLabeller;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * FenExplanation
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class FenExplanation
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    private ClassicalBoard $board;

    /**
     * Evaluation function.
     *
     * @var \Chess\Function\StandardFunction
     */
    private StandardFunction $function;

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
     * @param bool $isEvaluated
     */
    public function __construct(ClassicalBoard $board, bool $isEvaluated = false)
    {
        $this->board = $board;

        $this->function = new StandardFunction();

        $this->explain();

        if ($isEvaluated) {
            $balance = (new FenHeuristics($this->board->toFen()))->getBalance();
            $label = (new CountLabeller())->label($balance);
            $this->paragraph[] = "Overall, {$label[Color::W]} {$this->noun($label[Color::W])} {$this->verb($label[Color::W])} favoring White while {$label[Color::B]} {$this->verb($label[Color::B])} favoring Black.";
        }
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
     * Calculates the paragraph.
     *
     * @return \Chess\Tutor\FenExplanation
     */
    private function explain(): FenExplanation
    {
        foreach ($this->function->getEval() as $key => $val) {
            $eval = new $key($this->board);
            if ($phrases = $eval->getPhrases()) {
                $this->paragraph = [...$this->paragraph, ...$phrases];
            }
        }

        return $this;
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
