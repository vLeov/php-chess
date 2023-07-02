<?php

namespace Chess\Play;

use Chess\FenToBoard;
use Chess\Exception\PlayException;
use Chess\Movetext\RavMovetext;
use Chess\Movetext\SanMovetext;
use Chess\Play\SanPlay;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Recursive Annotation Variation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class RavPlay extends AbstractPlay
{
    /**
     * RAV movetext.
     *
     * @var array
     */
    protected RavMovetext $ravMovetext;

    /**
     * RAV breakdown.
     *
     * @var array
     */
    protected array $breakdown;

    protected array $resume;

    /**
     * Constructor.
     *
     * @param string $movetext
     * @param ClassicalBoard $board
     */
    public function __construct(string $movetext, ClassicalBoard $board = null)
    {
        $this->initialBoard = $board ?? new ClassicalBoard();
        $this->board = $board ?? new ClassicalBoard();
        $this->fen = [$this->board->toFen()];
        $this->ravMovetext = new RavMovetext($this->board->getMove(), $movetext);
        $this->ravMovetext->validate();

        $this->breakdown();
    }

    /**
     * Returns the RAV movetext.
     *
     * @return RavMovetext
     */
    public function getRavMovetext(): RavMovetext
    {
        return $this->ravMovetext;
    }

    /**
     * Returns the breakdown of the variations.
     *
     * @return array
     */
    public function getBreakdown(): array
    {
        return $this->breakdown;
    }

    /**
     * Semantically validated movetext.
     *
     * Makes the moves in the main variation of a RAV movetext.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\RavPlay
     */
    public function validate(): RavPlay
    {
        $moves = (new SanMovetext(
            $this->ravMovetext->getMove(),
            $this->ravMovetext->main()
        ))->getMoves();

        foreach ($moves as $key => $val) {
            if (!$this->board->play($this->board->getTurn(), $val)) {
                throw new PlayException();
            }
        }

        return $this;
    }

    /**
     * Calculates the FEN history.
     *
     * @return array
     */
    public function fen(): RavPlay
    {
        $sanPlay = new SanPlay($this->breakdown[0], $this->initialBoard);
        $board = $sanPlay->validate()->getBoard();
        $this->fen = $sanPlay->getFen();
        $this->resume[$this->breakdown[0]] = $board;
        for ($i = 1; $i < count($this->breakdown); $i++) {
            $sanMovetext = new SanMovetext($this->ravMovetext->getMove(), $this->breakdown[$i]);
            foreach ($this->resume as $key => $val) {
                $sanMovetextKey = new SanMovetext($this->ravMovetext->getMove(), $key);
                if ($this->isParent($sanMovetextKey->getLastMove(), $sanMovetext->getFirstMove())) {
                    if ($this->isUndo($sanMovetextKey->getLastMove(), $sanMovetext->getFirstMove())) {
                        $undo = $val->undo();
                        $board = FenToBoard::create($undo->toFen(), $this->initialBoard);
                    } else {
                        $board = FenToBoard::create($val->toFen(), $this->initialBoard);
                    }
                    break;
                }
            }

            // try {
                $sanPlay = new SanPlay($this->breakdown[$i], $board);
                $board = $sanPlay->validate()->getBoard();
                $fen = $sanPlay->getFen();
                array_shift($fen);
                $this->fen = [
                    ...$this->fen,
                    ...$fen,
                ];
                $this->resume[$this->breakdown[$i]] = $board;
            // } catch (\Exception $e) {
            // }
        }

        return $this;
    }

    /**
     * A breakdown of the variations for further processing.
     *
     * @return array
     */
    protected function breakdown()
    {
        $arr = preg_split("/[()]+/", $this->ravMovetext->filtered(), -1, PREG_SPLIT_NO_EMPTY);
        $arr = array_map('trim', $arr);
        $arr = array_values(array_filter($arr));

        $this->breakdown = $arr;
    }

    protected function isParent(string $a, string $b)
    {
        $foo = new SanMovetext($this->ravMovetext->getMove(), $a);
        $bar = new SanMovetext($this->ravMovetext->getMove(), $b);
        if ($foo->getMetadata()->number->first === $bar->getMetadata()->number->first) {
            return true;
        } elseif ($foo->getMetadata()->number->first !== $foo->getMetadata()->number->current) {
            if ($foo->getMetadata()->number->first + 1 === $bar->getMetadata()->number->first) {
                if ($bar->getMetadata()->turn->start === Color::W) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function isUndo(string $a, string $b)
    {
        $foo = new SanMovetext($this->ravMovetext->getMove(), $a);
        $bar = new SanMovetext($this->ravMovetext->getMove(), $b);
        if ($foo->getMetadata()->turn->current === $bar->getMetadata()->turn->current) {
            return true;
        }

        return false;
    }
}
