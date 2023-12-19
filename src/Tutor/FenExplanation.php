<?php

namespace Chess\Tutor;

use Chess\Function\StandardFunction;
use Chess\Variant\Capablanca\Board as CapablancaBoard;
use Chess\Variant\Capablanca\FEN\StrToBoard as CapablancaFenStrToBoard;
use Chess\Variant\CapablancaFischer\Board as CapablancaFischerBoard;
use Chess\Variant\Chess960\Board as Chess960Board;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\FEN\StrToBoard as ClassicalFenStrToBoard;

/**
 * FenExplanation
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class FenExplanation
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    private ClassicalBoard $board;

    /**
     * Evaluation function.
     *
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
     * @param string $fen
     * @param string $variant
     */
    public function __construct(string $fen, string $variant = '')
    {
        if ($variant === Chess960Board::VARIANT) {
            $this->board = (new ClassicalFenStrToBoard($fen))->create();
        } elseif ($variant === CapablancaBoard::VARIANT) {
            $this->board = (new CapablancaFenStrToBoard($fen))->create();
        } elseif ($variant === CapablancaFischerBoard::VARIANT) {
            $this->board = (new CapablancaFenStrToBoard($fen))->create();
        } else {
            $this->board = (new ClassicalFenStrToBoard($fen))->create();
        }

        $this->function = new StandardFunction();

        $this->explain();
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

    /**
     * Calculates the paragraph.
     *
     * @return \Chess\Tutor\FenExplanation
     */
    private function explain(): FenExplanation
    {
        foreach ($this->function->getEval() as $key => $val) {
            $eval = new $key($this->board);
            if ($phrases = $eval->getPhrases()) {
                $this->paragraph = [...$this->paragraph, ...$phrases];
            }
        }

        return $this;
    }
}
