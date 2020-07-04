<?php

namespace PGNChess\Tests\Unit\Heuristic;

use PGNChess\Heuristic\Snapshot\Space as SpaceSnapshot;
use PGNChess\Tests\AbstractUnitTestCase;

class SnapshotTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $snapshot = (new SpaceSnapshot)
                        ->take('1.Nf3 Nf6 2.c4 c5 3.g3 b6 4.Bg2 Bb7 5.O-O e6 6.Nc3 a6 7.d4 cxd4 8.Qxd4 d6');

        $this->assertFalse($snapshot);
    }
}
