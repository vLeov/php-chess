<?php

namespace PGNChess\Tests\Unit\Evaluation\Material;

use PGNChess\Board;
use PGNChess\Evaluation\Connectivity as ConnectivityEvaluation;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Unit\Sample\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;

class ConnectivityTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board))->play();

        $expected = [
            Symbol::WHITE => 30,
            Symbol::BLACK => 34,
        ];

        $connEvald = (new ConnectivityEvaluation($board))->evaluate();

        $this->assertEquals($expected, $connEvald);
    }
}
