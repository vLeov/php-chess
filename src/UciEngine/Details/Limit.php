<?php

namespace Chess\UciEngine\Details;

/**
 * UCI Limit for handling the analysis limit.
 */
class Limit
{
    /**
     * Time to search in milliseconds.
     *
     * @var int|null
     */
    private ?int $movetime;

    /**
     * Depth to search.
     *
     * @var int|null
     */

    private ?int $depth;

    /**
     * Nodes to search.
     *
     * @var int|null
     */
    private ?int $nodes;

    /**
     * Search for Mate in x moves. Not supported by all engines.
     *
     * @var int|null
     */
    private ?int $mate;

    /**
     * Time to search in milliseconds.
     *
     * @var int|null
     */
    private ?int $whiteClock;

    /**
     * Time to search in milliseconds.
     *
     * @var int|null
     */
    private ?int $blackClock;

    /**
     * Time to search in milliseconds.
     *
     * @var int|null
     */
    private ?int $whiteInc;

    /**
     * Time to search in milliseconds.
     *
     * @var int|null
     */
    private ?int $blackInc;

    /**
     * Remaining moves to the next time control.
     *
     * @var int|null
     */
    private ?int $remainingMoves;

    public function __construct(
        $movetime = null,
        $depth = null,
        $nodes = null,
        $mate = null,
        $whiteClock = null,
        $blackClock = null,
        $whiteInc = null,
        $blackInc = null,
        $remainingMoves = null
    ) {
        $this->movetime = $movetime;
        $this->depth = $depth;
        $this->nodes = $nodes;
        $this->mate = $mate;
        $this->whiteClock = $whiteClock;
        $this->blackClock = $blackClock;
        $this->whiteInc = $whiteInc;
        $this->blackInc = $blackInc;
        $this->remainingMoves = $remainingMoves;
    }

    public function getMovetime(): ?int
    {
        return $this->movetime;
    }

    public function setMovetime(int $movetime): Limit
    {
        $this->movetime = $movetime;

        return $this;
    }

    public function getDepth(): ?int
    {
        return $this->depth;
    }

    public function setDepth(int $depth): Limit
    {
        $this->depth = $depth;

        return $this;
    }

    public function getNodes(): ?int
    {
        return $this->nodes;
    }

    public function setNodes(int $nodes): Limit
    {
        $this->nodes = $nodes;

        return $this;
    }

    public function getMate(): ?int
    {
        return $this->mate;
    }

    public function setMate(int $mate): Limit
    {
        $this->mate = $mate;

        return $this;
    }

    public function getWhiteClock(): ?int
    {
        return $this->whiteClock;
    }

    public function setWhiteClock(int $whiteClock): Limit
    {
        $this->whiteClock = $whiteClock;

        return $this;
    }

    public function getBlackClock(): ?int
    {
        return $this->blackClock;
    }

    public function setBlackClock(int $blackClock): Limit
    {
        $this->blackClock = $blackClock;

        return $this;
    }

    public function getWhiteInc(): ?int
    {
        return $this->whiteInc;
    }

    public function setWhiteInc(int $whiteInc): Limit
    {
        $this->whiteInc = $whiteInc;

        return $this;
    }

    public function getBlackInc(): ?int
    {
        return $this->blackInc;
    }

    public function setBlackInc(int $blackInc): Limit
    {
        $this->blackInc = $blackInc;

        return $this;
    }

    public function getRemainintMoves(): ?int
    {
        return $this->remainingMoves;
    }

    public function setRemainintMoves(int $remainingMoves): Limit
    {
        $this->remainingMoves = $remainingMoves;

        return $this;
    }
}
