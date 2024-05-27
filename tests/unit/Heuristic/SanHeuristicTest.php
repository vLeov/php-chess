<?php

namespace Chess\Tests\Unit;

use Chess\Heuristic\SanHeuristic;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\FEN\StrToBoard;

class SanHeuristicTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function space_get_balance_e4_d5_exd5_Qxd5()
    {
        $name = 'Space';

        $movetext = '1.e4 d5 2.exd5 Qxd5';

        $balance = (new SanHeuristic($name, $movetext))->getBalance();

        $expected = [ 0.0, 8.0, 2.0, 4.0, -11.0 ];

        $this->assertSame($expected, $balance);
    }
}
