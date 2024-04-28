<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * PgnEvaluation
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class PgnEvaluation extends AbstractParagraph
{
    /**
     * Constructor.
     *
     * @param string $pgn
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(string $pgn, ClassicalBoard $board)
    {
        $this->board = $board;

        $fenEvaluation = new FenEvaluation($this->board);
        $this->board = $fenEvaluation->getBoard();
        $this->board->play($board->getTurn(), $pgn);

        foreach ((new FenEvaluation($this->board))->getParagraph() as $key => $val) {
            if (!in_array($val, $fenEvaluation->getParagraph())) {
                $this->paragraph[] = $val;
            }
        }
    }
}
