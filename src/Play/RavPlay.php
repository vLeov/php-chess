<?php

namespace Chess\Play;

use Chess\FenToBoard;
use Chess\Exception\PlayException;
use Chess\Movetext\RavMovetext;
use Chess\Movetext\SanMovetext;
use Chess\Play\SanPlay;
use Chess\Variant\Classical\Board as ClassicalBoard;

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

    protected $foo;

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
     * Returns the breakdown.
     *
     * @return array
     */
    public function getBreakdown(): array
    {
        return $this->breakdown;
    }

    /**
     * Calculates and returns the FEN history.
     *
     * @return array
     */
    public function getFen(): array
    {
        $sanPlay = new SanPlay($this->breakdown[0], $this->initialBoard);
        $board = $sanPlay->play()->getBoard();
        $this->fen = $sanPlay->getFen();
        $resume = [$board];
        for ($i = 1; $i < count($this->breakdown); $i++) {
            $current = new SanMovetext($this->ravMovetext->getMove(), $this->breakdown[$i]);
            for ($j = $i - 1; $j >= 0; $j--) {
                $prev = new SanMovetext($this->ravMovetext->getMove(), $this->breakdown[$j]);
                if ($current->startNumber() === $prev->endingNumber()) {
                    if (str_contains($this->ravMovetext->inline(), "({$this->breakdown[$i]}")) {
                        $undo = $resume[$j]->undo();
                        $board = FenToBoard::create(
                            $undo->toFen(),
                            $board
                        );
                    } else {
                        $board = FenToBoard::create(
                            $resume[$j]->toFen(),
                            $board
                        );
                    }
                    $sanPlay = new SanPlay($this->breakdown[$i], $board);
                    $board = $sanPlay->play()->getBoard();
                    $fen = $sanPlay->getFen();
                    array_shift($fen);
                    $this->fen = [
                        ...$this->fen,
                        ...$fen,
                    ];
                    $resume[] = $board;
                    break;
                }
            }
        }

        return $this->fen;
    }

    /**
     * Plays the main variation of a RAV movetext.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\RavPlay
     */
    public function play(): RavPlay
    {
        $mainMoves = (new SanMovetext(
            $this->ravMovetext->getMove(),
            $this->ravMovetext->main()
        ))->getMoves();

        foreach ($mainMoves as $key => $val) {
            if (!$this->board->play($this->board->getTurn(), $val)) {
                throw new PlayException();
            }
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
        $data = preg_split("/[()]+/", $this->ravMovetext->inline(), -1, PREG_SPLIT_NO_EMPTY);
        $data = array_map('trim', $data);
        $data = array_values(array_filter($data));

        $this->breakdown = $data;
    }
}
