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
    private FenExplanation $fenExplanation;

    /**
     * Paragraph.
     *
     * @var array
     */
    private array $paragraph = [];

    /**
     * Heuristic evaluation.
     *
     * @var bool
     */
    private bool $isEvaluated;

    /**
     * Variant.
     *
     * @var string
     */
    private string $variant;

    /**
     * Constructor.
     *
     * @param string $pgn
     * @param string $fen
     * @param bool $isEvaluated
     * @param string $variant
     */
    public function __construct(string $pgn, string $fen, bool $isEvaluated = false, string $variant = '')
    {
        $this->fenExplanation = new FenExplanation($fen, $variant);

        $this->isEvaluated = $isEvaluated;

        $this->variant = $variant;

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
        $fenParagraph = new FenExplanation($board->toFen(), $this->isEvaluated, $this->variant);
        foreach ($fenParagraph->getParagraph() as $key => $val) {
            if (!in_array($val, $this->fenExplanation->getParagraph())) {
                $this->paragraph[] = $val;
            }
        }

        return $this;
    }
}
