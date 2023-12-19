<?php

namespace Chess\Tutor;

/**
 * PgnExplanation
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class PgnExplanation
{
    /**
     * FEN explanation.
     *
     * @var \Chess\Tutor\FenExplanation
     */
    private FenExplanation $FenExplanation;

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
     * @param string $fen
     * @param string $variant
     */
    public function __construct(string $pgn, string $fen, string $variant = '')
    {
        $this->fenParagraph = new FenExplanation($fen, $variant);

        $this->explain($pgn, $variant);
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
     * @return \Chess\Tutor\PgnExplanation
     */
    private function explain(string $pgn, string $variant): PgnExplanation
    {
        $board = $this->fenParagraph->getBoard();
        $board->play($board->getTurn(), $pgn);
        $fenParagraph = new FenExplanation($board->toFen(), $variant);
        foreach ($fenParagraph->getParagraph() as $key => $val) {
            if (!in_array($val, $this->fenParagraph->getParagraph())) {
                $this->paragraph[] = $val;
            }
        }

        return $this;
    }
}
