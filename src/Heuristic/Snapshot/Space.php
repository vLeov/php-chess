<?php

namespace PGNChess\Heuristic\Snapshot;

use PGNChess\Evaluation\Space as SpaceEvaluation;
use PgnChess\Board;

/**
 * Space snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Space
{
    protected $board;

    public function __construct()
    {
        $this->board = new Board;
    }

    public function take(string $movetext): array
    {
        // TODO

        return [];
    }
}
