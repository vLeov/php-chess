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
     * White has x msec left on the clock.
     *
     * @var int|null
     */
    private ?int $wtime;

    /**
     * Black has x msec left on the clock.
     *
     * @var int|null
     */
    private ?int $btime;

    /**
     * White increment per move in mseconds.
     *
     * @var int|null
     */
    private ?int $winc;

    /**
     * Black increment per move in mseconds.
     *
     * @var int|null
     */
    private ?int $binc;

    /**
     * Remaining moves to the next time control.
     *
     * @var int|null
     */
    private ?int $movestogo;

    /**
     * Constructor.
     *
     * @param int|null $movetime
     * @param int|null $depth
     * @param int|null $nodes
     * @param int|null $mate
     * @param int|null $wtime
     * @param int|null $btime
     * @param int|null $winc
     * @param int|null $binc
     * @param int|null $movestogo
     */
    public function __construct(
        $movetime = null,
        $depth = null,
        $nodes = null,
        $mate = null,
        $wtime = null,
        $btime = null,
        $winc = null,
        $binc = null,
        $movestogo = null
    ) {
        $this->movetime = $movetime;
        $this->depth = $depth;
        $this->nodes = $nodes;
        $this->mate = $mate;
        $this->wtime = $wtime;
        $this->btime = $btime;
        $this->winc = $winc;
        $this->binc = $binc;
        $this->movestogo = $movestogo;
    }

    /**
     * Returns the movetime param.
     *
     * @return int|null
     */
    public function getMovetime(): ?int
    {
        return $this->movetime;
    }

    /**
     * Sets the movetime param.
     *
     * @param int $movetime
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setMovetime(int $movetime): Limit
    {
        $this->movetime = $movetime;

        return $this;
    }

    /**
     * Returns the depth param.
     *
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->depth;
    }

    /**
     * Sets the depth param.
     *
     * @param int $depth
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setDepth(int $depth): Limit
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Returns the nodes param.
     *
     * @return int|null
     */
    public function getNodes(): ?int
    {
        return $this->nodes;
    }

    /**
     * Sets the nodes param.
     *
     * @param int $nodes
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setNodes(int $nodes): Limit
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * Returns the mate param.
     *
     * @return int|null
     */
    public function getMate(): ?int
    {
        return $this->mate;
    }

    /**
     * Sets the mate param.
     *
     * @param int $mate
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setMate(int $mate): Limit
    {
        $this->mate = $mate;

        return $this;
    }

    /**
     * Returns the wtime param.
     *
     * @return int|null
     */
    public function getWtime(): ?int
    {
        return $this->wtime;
    }

    /**
     * Sets the wtime param.
     *
     * @param int $wtime
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setWtime(int $wtime): Limit
    {
        $this->wtime = $wtime;

        return $this;
    }

    /**
     * Returns the btime param.
     *
     * @return int|null
     */
    public function getBtime(): ?int
    {
        return $this->btime;
    }

    /**
     * Sets the btime param.
     *
     * @param int $btime
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setBtime(int $btime): Limit
    {
        $this->btime = $btime;

        return $this;
    }

    /**
     * Returns the winc param.
     *
     * @return int|null
     */
    public function getWinc(): ?int
    {
        return $this->winc;
    }

    /**
     * Sets the winc param.
     *
     * @param int $winc
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setWinc(int $winc): Limit
    {
        $this->winc = $winc;

        return $this;
    }

    /**
     * Returns the binc param.
     *
     * @return int|null
     */
    public function getBinc(): ?int
    {
        return $this->binc;
    }

    /**
     * Sets the binc param.
     *
     * @param int $binc
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setBinc(int $binc): Limit
    {
        $this->binc = $binc;

        return $this;
    }

    /**
     * Returns the movestogo param.
     *
     * @return int|null
     */
    public function getMovestogo(): ?int
    {
        return $this->movestogo;
    }

    /**
     * Sets the movestogo param.
     *
     * @param int $movestogo
     * @return \Chess\UciEngine\Details\Limit
     */
    public function setMovestogo(int $movestogo): Limit
    {
        $this->movestogo = $movestogo;

        return $this;
    }
}
