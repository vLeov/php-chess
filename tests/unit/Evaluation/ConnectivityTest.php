<?php

namespace Chess\Tests\Unit\Evaluation\Material;

use Chess\Board;
use Chess\Evaluation\Connectivity as ConnectivityEvaluation;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;

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
