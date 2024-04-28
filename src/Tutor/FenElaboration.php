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
        foreach ((new StandardFunction())->getEval() as $key => $val) {
            $eval = new $key($board);
            if (is_a($eval, ElaborateEvalInterface::class)) {
                if ($phrases = $eval->getElaboration()) {
                    $this->paragraph = [...$this->paragraph, ...$phrases];
                }
            }
        }
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
