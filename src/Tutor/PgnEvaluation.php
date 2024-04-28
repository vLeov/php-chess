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
        $fenEvaluation = new FenEvaluation($board);
        $board = $fenEvaluation->getBoard();
        $board->play($board->getTurn(), $pgn);

        foreach ((new FenEvaluation($board))->getParagraph() as $key => $val) {
            if (!in_array($val, $fenEvaluation->getParagraph())) {
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
