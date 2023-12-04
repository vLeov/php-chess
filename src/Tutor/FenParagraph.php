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
 * FenParagraph
 *
 * Human-like sentence.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class FenParagraph
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected ClassicalBoard $board;

    /**
     * The evaluation function.
     *
     * @var \Chess\Function\StandardFunction
     */
    protected StandardFunction $function;

    /**
     * The sentence.
     *
     * @var array
     */
    protected array $sentence = [];

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
     * Returns the sentence.
     *
     * @return array
     */
    public function getSentence(): array
    {
        return $this->sentence;
    }

    /**
     * Calculates the sentence.
     *
     * @return FenHeuristics
     */
    protected function explain(): FenParagraph
    {
        foreach ($this->function->getEval() as $key => $val) {
            $eval = new $key($this->board);
            if ($phrases = $eval->getPhrases()) {
                $this->sentence = [...$this->sentence, ...$phrases];
            }
        }

        return $this;
    }
}
