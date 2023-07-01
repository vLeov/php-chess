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
            $next = $this->findNext($sanMovetext);
            $sanPlay = new SanPlay($this->breakdown[$i], $next);
            $board = $sanPlay->validate()->getBoard();
            $fen = $sanPlay->getFen();
            array_shift($fen);
            $this->fen = [
                ...$this->fen,
                ...$fen,
            ];
            $this->resume[$this->breakdown[$i]] = $board;
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

    /**
     * Returns the next board to be processed.
     *
     * @param SanMovetext $sanMovetext
     * @return object
     */
    protected function findNext(SanMovetext $sanMovetext): ?object
    {
        foreach (array_reverse($this->resume, true) as $key => $val) {
            $sanMovetextKey = new SanMovetext($this->ravMovetext->getMove(), $key);
            if ($sanMovetext->getMetadata()->number->first === $sanMovetextKey->getMetadata()->number->current) {
                if ($sanMovetextKey->getMetadata()->number->last === $sanMovetextKey->getMetadata()->number->current) {
                    if ($sanMovetext->getMetadata()->turn->start === Color::W) {
                        //      5.Kd5,
                        // ---> 5.Ke8,
                        $undo = $val->undo();
                        $board = FenToBoard::create($undo->toFen(), $this->initialBoard);
                    } else {
                        //      5.Kd5,
                        // ---> 5...Ke8,
                        $board = FenToBoard::create($val->toFen(), $this->initialBoard);
                    }
                } else {
                    if ($sanMovetext->getMetadata()->turn->start === Color::W) {
                        //      5.Kd5 Kc8,
                        // ---> 6.Kd6
                        $board = FenToBoard::create($val->toFen(), $this->initialBoard);
                    } else {
                        //      5.Kd5 Kc8,
                        // ---> 6...Kd6
                        //      do nothing
                    }
                }
            } else {
                if ($sanMovetextKey->getMetadata()->number->last === $sanMovetextKey->getMetadata()->number->current) {
                    if ($sanMovetext->getMetadata()->turn->start === Color::W) {
                        // do nothing
                    } else {
                        // do nothing
                    }
                } else {
                    if ($sanMovetext->getMetadata()->turn->start === Color::W) {
                        //      5.Kd5 Kc8,
                        // ---> 5.Ke8,
                        //      do nothing
                    } elseif ($sanMovetext->getMetadata()->turn->start === Color::B) {
                        //      5.Kd5 Kc8,
                        // ---> 5...Ke8,
                        $undo = $val->undo();
                        $board = FenToBoard::create($undo->toFen(), $this->initialBoard);
                    }
                }
            }
        }

        return $board;
    }
}
