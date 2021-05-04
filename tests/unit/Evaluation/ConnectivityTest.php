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
    public function start()
    {
        $connEvald = (new ConnectivityEvaluation(new Board()))->evaluate();

        $expected = [
            Symbol::WHITE => 20,
            Symbol::BLACK => 20,
        ];

        $this->assertEquals($expected, $connEvald);
    }

    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board()))->play();

        $expected = [
            Symbol::WHITE => 19,
            Symbol::BLACK => 23,
        ];

        $connEvald = (new ConnectivityEvaluation($board))->evaluate();

        $this->assertEquals($expected, $connEvald);
    }
}
