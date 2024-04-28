<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * PgnEvaluation
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class PgnEvaluation
{
    /**
     * FEN evaluation.
     *
     * @var \Chess\Tutor\FenEvaluation
     */
    private FenEvaluation $fenEvaluation;

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
        $this->fenEvaluation = new FenEvaluation($board);

        $board = $this->fenEvaluation->getBoard();
        $board->play($board->getTurn(), $pgn);
        $fenEvaluation = new FenEvaluation($board);

        foreach ($fenEvaluation->getParagraph() as $key => $val) {
            if (!in_array($val, $this->fenEvaluation->getParagraph())) {
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
