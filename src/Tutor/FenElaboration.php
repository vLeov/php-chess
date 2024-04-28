<?php

namespace Chess\Tutor;

use Chess\Eval\ElaborateEvalInterface;
use Chess\Function\StandardFunction;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * FenElaboration
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class FenElaboration
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    private ClassicalBoard $board;

    /**
     * Evaluation function.
     *ions
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
     */
    public function __construct(ClassicalBoard $board)
    {
        $this->board = $board;
        $this->function = new StandardFunction();

        foreach ($this->function->getEval() as $key => $val) {
            $eval = new $key($this->board);
            if (is_a($eval, ElaborateEvalInterface::class)) {
                if ($phrases = $eval->getElaboration()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
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
}
