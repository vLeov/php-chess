<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * PgnExplanation
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class PgnExplanation
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
     * @param string $pgn
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(string $pgn, ClassicalBoard $board)
    {
        $fenExplanation = new FenExplanation($board);
        $board = $fenExplanation->getBoard();
        $board->play($board->getTurn(), $pgn);

        foreach ((new FenExplanation($board))->getParagraph() as $key => $val) {
            if (!in_array($val, $fenExplanation->getParagraph())) {
                $this->paragraph[] = $val;
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
