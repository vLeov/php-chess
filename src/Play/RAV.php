<?php

namespace Chess\Play;

use Chess\Exception\PlayException;
use Chess\Movetext\RAV as RavMovetext;
use Chess\Movetext\SAN as SanMovetext;
use Chess\Play\SAN as SanPlay;
use Chess\Variant\Classical\Board as ClassicalBoard;

/**
 * Recursive Annotation Variation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class RAV extends AbstractPlay
{
    /**
     * RAV movetext.
     *
     * @var array
     */
    protected RavMovetext $san;

    /**
     * Breakdown.
     *
     * @var array
     */
    protected array $breakdown;


    /**
     * Constructor.
     *
     * @param string $movetext
     * @param ClassicalBoard $board
     */
    public function __construct(string $movetext, ClassicalBoard $board = null)
    {
        $this->board = $board ?? new ClassicalBoard();
        $this->fen = [$this->board->toFen()];
        $this->rav = new RavMovetext($this->board->getMove(), $movetext);

        $this->rav->validate();

        $this->breakdown();
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
     * Plays the main variation of a RAV movetext.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\RAV
     */
    public function play(): RAV
    {
        $mainMoves = (new SanMovetext(
            $this->rav->getMove(),
            $this->rav->main()
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
        $data = preg_split("/[()]+/", $this->rav->filter(), -1, PREG_SPLIT_NO_EMPTY);
        $data = array_map('trim', $data);
        $data = array_values(array_filter($data));

        $this->breakdown = $data;
    }

    // TODO
    protected function fen()
    {
        $board = (new SanPlay($this->breakdown[0], $this->board))
            ->play()
            ->getBoard();

        $this->fen = $board->getFen();

        for ($i = 1; $i < count($this->breakdown); $i++) {
            $current = new SanMovetext($this->rav->getMove(), $this->breakdown[$i]);
            for ($j = $i; $j < 0; $j--) {
                $found = new SanMovetext($this->rav->getMove(), $this->breakdown[$j]);
                if ($current->startsWith() === $found->endsWith()) {
                    if ($current->isParenthesized()) {
                        $board = $board->undo();
                    }
                    $board = (new SanPlay($this->breakdown[$i], $board))
                        ->play()
                        ->getBoard();
                    $this->fen = [
                        ...$this->fen,
                        ...$board->getFen(),
                    ];
                }
            }
        }
    }
}
