<?php

namespace Chess\Tutor;

use Chess\Variant\Classical\Board;

/**
 * AbstractParagraph
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
abstract class AbstractParagraph
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $board;

    /**
     * Paragraph.
     *
     * @var array
     */
    protected array $paragraph = [];


    /**
     * Returns the board.
     *
     * @return \Chess\Variant\Classical\Board
     */
    public function getBoard(): Board
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
