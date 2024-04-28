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
     * FEN explanation.
     *
     * @var \Chess\Tutor\FenExplanation
     */
    private FenExplanation $fenExplanation;

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
        $this->fenExplanation = new FenExplanation($board);

        $this->explain($pgn);
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
     * @param string $pgn
     * @return \Chess\Tutor\PgnExplanation
     */
    private function explain(string $pgn): PgnExplanation
    {
        $board = $this->fenExplanation->getBoard();
        $board->play($board->getTurn(), $pgn);
        $fenParagraph = new FenExplanation($board);
        foreach ($fenParagraph->getParagraph() as $key => $val) {
            if (!in_array($val, $this->fenExplanation->getParagraph())) {
                $this->paragraph[] = $val;
            }
        }

        return $this;
    }
}
